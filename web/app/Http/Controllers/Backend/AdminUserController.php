<?php

namespace App\Http\Controllers\Backend;

use DB;
use File;
use Session;
use Storage;
use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\AdminUserRepository as Admin;
use App\Repositories\RoleRepository as Role;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\Backend\AdminUserRequest;
use App\Http\Controllers\Backend\BackendController;

class AdminUserController extends BackendController
{
    protected $user;
    protected $role;
    protected $entity = 'admin_user';

    public function __construct(Admin $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;

        parent::__construct();
    }

    private function initDataColumn()
    {
        return [
            ['data' => 'select', 'name' => 'select', 'selectAll' => true, 'sortable' => false, 'searchable' => false, 'width' => '3%' ],
            ['data' => 'id', 'name' => 'id', 'title' => trans('backend/admin_users.id'), 'searchType' => 'text', 'width' => '5%' ],
            ['data' => 'name', 'name' => 'name', 'title' => trans('backend/admin_users.name'), 'searchType' => 'text' ],
            ['data' => 'email', 'name' => 'email', 'title' => trans('backend/admin_users.email'), 'searchType' => 'text' ],
            ['data' => 'avatar', 'name' => 'avatar', 'title' => trans('backend/admin_users.avatar'), 'sortable' => false, 'sClass' => 'dt-body-center' ],
            ['data' => 'status', 'name' => 'status', 'title' => trans('backend/admin_users.status'), 'sClass' => 'dt-body-center', 'searchType' => 'select', 'searchOption' => config('constant.status_list') ],
            ['data' => 'action', 'name' => 'action', 'title' => trans('backend/systems.action'), 'sortable' => false, 'searchable' => false ]
        ];
    }

    public function index()
    {
        $this->authorizeForAdmin('index', $this->user->getObject());

        if($this->authUser->can('add', $this->user->getObject())) {
            $actions = [
                ['url' => route('admin.admin_users.add'), 'label' => trans('backend/systems.add'), 'icon' => 'plus' ] 
            ];
        } else {
            $actions = [];
        }

        $datatables = [
            'columns' => get_datatable_column($this->initDataColumn()),
            'searchColumns' => get_datatable_search_column($this->initDataColumn()),
            'defaultOrder' => get_datatable_default_order($this->initDataColumn()),
        ];

        $deleteSelectedUrl = route('admin.admin_users.delete_selected');

        return view('backend.admin-users.index', compact('datatables', 'deleteSelectedUrl', 'actions'));
    }

    public function getAdminUserListAsJson()
    {
        $this->authorizeForAdmin('index', $this->user->getObject());
        $users = $this->user->getObject()->select(['*']);

        $datatable = Datatables::of($users);

        $datatable->editColumn('status', function ($row) {
            return '<span class="badge" style="background: '.$row->getStatusColor().'">'.$row->getStatusAsText().'</span>';
        });

        $datatable->editColumn('avatar', function ($row) {
            return '<img src="'.$row->getAvatar().'" class="img-responsive img-circle" style="max-width: 30px; margin: 0 auto;">';
        });

        $datatable->addColumn('select', function($row) {
            if($this->authUser->can('delete', $row)) {
                return '<label style="margin-bottom: 0"><input name="datatableSelect" type="checkbox" class="minimal-red datatableSelect" value="'.$row->id.'"></label>';
            }
        });

        $datatable->addColumn('action', function($row){
            $buttons = [];
            if($this->authUser->can('view', $row)) {
                $buttons['view'] = ['url' => route('admin.admin_users.view', ['id' => $row->id])];
            }
            if($this->authUser->can('edit', $row)) {
                $buttons['edit'] = ['url' => route('admin.admin_users.edit', ['id' => $row->id])];
            }
            if($this->authUser->can('delete', $row)) {
                $buttons['delete'] = [
                    'url' => route('admin.admin_users.delete', ['id' => $row->id])
                ];
            }

            return (string)view('backend.partial.action', compact('buttons'));
        });

        return $datatable->make(true);
    }

    public function getAdd()
    {
        $user = $this->user->getObject();

        $this->authorizeForAdmin('add', $user);
        if($this->authUser->can('index', $user)) {
            $actions = [
                ['url' => route('admin.admin_users.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ]
            ];
        } else {
            $actions = [];
        }

        $defaultRole = $this->role->getDefaultRole();
        $checkboxDatas = $this->role->getAssignRole();
        $treeTitle = trans('backend/roles.index');
        $treeName = 'roles';

        return view('backend.admin-users.add', compact(
            'user',
            'actions',
            'defaultRole',
            'checkboxDatas',
            'treeTitle',
            'treeName'
        ));
    }

    public function postAdd(AdminUserRequest $request)
    {
        $user = $this->user->getObject();

        $this->authorizeForAdmin('add', $user);

        DB::beginTransaction();
        try {
            $data = $request->except('avatar');
            $data['status'] = config('constant.active_status');
            $user = $user->create($data);
            if($user == null) {
                throw new ModelSaveFailedException();
            }

            $roles = $request->roles;

            $user->roles()->attach($roles);

            $file = $request->file('avatar');
            if($file != null) {
                $this->uploadAvatar($user, $file);
            }

            DB::commit();
            Session::flash('success', trans('backend/messages.save_success', ['entity' => $this->entity]));
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            Session::flash('error', trans('backend/messages.save_failed', ['entity' => $this->entity]));
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.admin_users.index');
    }

    public function getEdit($id)
    {
        $user = $this->user->findOrFail($id);

        $this->authorizeForAdmin('edit', $user);
        $actions = [];
        if($this->authUser->can('index', $user)) {
            $actions[] = ['url' => route('admin.admin_users.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ];
        }
        if($this->authUser->can('view', $user)) {
            $actions[] = ['url' => route('admin.admin_users.view', ['id' => $user->id]), 'label' => trans('backend/systems.view'), 'icon' => 'eye' ];
        }

        $editMode = true;

        $defaultRole = $this->role->getDefaultRole();
        $checkboxDatas = $this->role->getAssignRole();
        $checkedDatas = $user->roles()->getRelatedIds()->toArray();
        $treeTitle = trans('backend/roles.index');
        $treeName = 'roles';

        return view('backend.admin-users.edit', compact(
            'user',
            'actions',
            'defaultRole',
            'checkboxDatas',
            'checkedDatas',
            'treeTitle',
            'treeName',
            'editMode'
        ));
    }

    public function postEdit($id, AdminUserRequest $request)
    {
        $user = $this->user->findOrFail($id);

        $this->authorizeForAdmin('edit', $user);

        DB::beginTransaction();

        try {
            $updated = $user->update($request->all());
            if(!$updated) {
                throw new ModelSaveFailedException();
            }

            $roles = $request->roles != null ? $request->roles : [];
            $user->roles()->sync($roles);

            $file = $request->file('avatar');
            if($file != null) {
                $this->uploadAvatar($user, $file);
            }

            DB::commit();
            Session::flash('success', trans('backend/messages.save_success', ['entity' => $this->entity]));
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', trans('backend/messages.save_failed', ['entity' => $this->entity]));
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.admin_users.index');
    }

    public function getView($id)
    {
        $user = $this->user->findOrFail($id);
        $this->authorizeForAdmin('view', $user);

        $actions = [];
        if($this->authUser->can('index', $user)) {
            $actions[] = ['url' => route('admin.admin_users.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ];
        }
        if($this->authUser->can('edit', $user)) {
            $actions[] = ['url' => route('admin.admin_users.edit', ['id' => $user->id]), 'label' => trans('backend/systems.edit'), 'icon' => 'pencil' ];
        }

        $deleteUrl = route('admin.admin_users.delete', ['id' => $user->id]);

        $data = ['user' => $user, 'actions' => $actions];

        if($this->authUser->can('delete', $user)) {
            $data['deleteUrl'] = $deleteUrl;
        }

        return view('backend.admin-users.view', $data);
    }

    public function postDelete($id)
    {
        $user = $this->user->findOrFail($id);
        $this->authorizeForAdmin('delete', $user);

        $result = ['res' => 0, 'error' => trans('backend/messages.delete_failed', ['entity' => $this->entity])];

        DB::beginTransaction();
        try{
            $deleted = $user->delete();

            if($deleted) {
                Session::flash('success', trans('backend/messages.delete_success', ['entity' => $this->entity]));
                $result = ['res' => 1, 'url' => route('admin.admin_users.index')];
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return response()->json($result);
    }

    public function postDeleteSelected(Request $request)
    {
        $selected = $request->selected;
        if($selected == '') {
            response()->json(['res' => 0, 'error' => trans('backend/systems.no_selected_item')]);
        }

        $selected = explode(',', $selected);

        $result = ['res' => 0, 'error' => trans('backend/messages.delete_failed', ['entity' => $this->entity])];

        DB::beginTransaction();
        try {
            $deleted = 0;
            foreach ($selected as $value) {
                $user = $this->user->findOrFail($value);
                if($this->authUser->can('delete', $user)){
                    $isDeleted = $user->delete();
                    $deleted += $isDeleted ? 1 : 0;
                }
            }
            if($deleted != count($selected)) {
                throw new ModelSaveFailedException();
            }

            DB::commit();
            session()->flash('success', trans('backend/messages.delete_success', ['entity' => $this->entity]));
            $result = ['res' => 1, 'url' => route('admin.admin_users.index')];
        } catch(Exception $e) {
            DB::rollback();
        }

        return response()->json($result);
    }

    public function uploadAvatar(Admin $user, $file)
    {
        try {
            $oldAvatar = $user->getAvatarPath();
            $extension = $file->getClientOriginalExtension();
            $fileName = str_random(32).$user->id.'.'.$extension;
            $put = Storage::disk('avatar')->put($fileName,  File::get($file));

            if($put <= 0) {
                throw new ModelSaveFailedException();
            }

            $user->avatar = $fileName;
            $saved = $user->save();

            if(!$saved) {
                throw new ModelSaveFailedException();
            }

            if(is_file($oldAvatar)) {
                if(!unlink($oldAvatar)) {
                    $newAvatar = $user->getAvatarPath();
                    if(is_file($newAvatar)) {
                        unlink($newAvatar);
                    }
                    throw new ModelSaveFailedException();
                }
            }

            return $saved;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }
}
