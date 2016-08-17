<?php

namespace App\Http\Controllers\Backend;

use DB;
use Session;
use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\PermissionRepository as Permission;
use App\Repositories\RoleRepository as Role;
use App\Http\Requests\Backend\RoleRequest;
use App\Exceptions\ModelSaveFailedException;
use App\Http\Controllers\Backend\BackendController;

class RoleController extends BackendController
{
    private $role;
    private $permission;
    private $entity = 'role';

    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;

        parent::__construct();
    }

    private function initDataColumn()
    {
        return [
            ['data' => 'select', 'name' => 'select', 'selectAll' => true, 'sortable' => false, 'searchable' => false, 'width' => '5%' ],
            ['data' => 'id', 'name' => 'id', 'title' => trans('backend/roles.id'), 'searchType' => 'text' ],
            ['data' => 'name', 'name' => 'name', 'title' => trans('backend/roles.name'), 'searchType' => 'text' ],
            ['data' => 'description', 'name' => 'description', 'title' => trans('backend/roles.description'), 'searchType' => 'text' ],
            ['data' => 'status', 'name' => 'status', 'title' => trans('backend/roles.status'), 'sClass' => 'dt-body-center', 'searchType' => 'select', 'searchOption' => config('constant.status_list') ],
            ['data' => 'system', 'name' => 'system', 'title' => trans('backend/roles.system'), 'sClass' => 'dt-body-center', 'searchType' => 'select', 'searchOption' => config('constant.system_list') ],
            ['data' => 'default', 'name' => 'default', 'title' => trans('backend/roles.default'), 'sClass' => 'dt-body-center', 'searchType' => 'select', 'searchOption' => config('constant.default_list') ],
            ['data' => 'action', 'name' => 'action', 'title' => trans('backend/systems.action'), 'sortable' => false, 'searchable' => false ]
        ];
    }

    public function index()
    {
        $this->authorizeForAdmin('index', $this->role->getObject());

        if($this->authUser->can('add', $this->role->getObject())) {
            $actions = [
                ['url' => route('admin.roles.add'), 'label' => trans('backend/systems.add'), 'icon' => 'plus' ] 
            ];
        } else {
            $actions = [];
        }

        $datatables = [
            'columns' => get_datatable_column($this->initDataColumn()),
            'searchColumns' => get_datatable_search_column($this->initDataColumn()),
            'defaultOrder' => get_datatable_default_order($this->initDataColumn()),
        ];

        $deleteSelectedUrl = route('admin.roles.delete_selected');

        return view('backend.roles.index', compact('datatables', 'deleteSelectedUrl', 'actions'));
    }

    public function getRoleListAsJson(Request $request)
    {
        $this->authorizeForAdmin('index', $this->role->getObject());
        $roles = $this->role->getObject()->select(['*']);

        $datatable = Datatables::of($roles);

        $datatable->editColumn('status', function ($row) {
            return '<span class="badge" style="background: '.$row->getStatusColor().'">'.$row->getStatusAsText().'</span>';
        });

        $datatable->editColumn('default', function ($row) {
            return $row->isDefault() ? '<i class="fa fa-check success"></i>' : '';
        });

        $datatable->editColumn('system', function ($row) {
            return $row->isSystem() ? '<i class="fa fa-check success"></i>' : '';
        });

        $datatable->addColumn('select', function($row) {
            if($this->authUser->can('delete', $row)) {
                return '<label style="margin-bottom: 0"><input name="datatableSelect" type="checkbox" class="minimal-red datatableSelect" value="'.$row->id.'"></label>';
            }
        });

        $datatable->addColumn('action', function($row){
            $buttons = [];
            if($this->authUser->can('view', $row)) {
                $buttons['view'] = ['url' => route('admin.roles.view', ['id' => $row->id])];
            }
            if($this->authUser->can('edit', $row)) {
                $buttons['edit'] = ['url' => route('admin.roles.edit', ['id' => $row->id])];
            }
            if($this->authUser->can('delete', $row)) {
                $buttons['delete'] = [
                    'url' => route('admin.roles.delete', ['id' => $row->id])
                ];
            }

            return (string)view('backend.partial.action', compact('buttons'));
        });

        return $datatable->make(true);
    }

    public function getView($id)
    {
        $role = $this->role->findOrFail($id);
        $this->authorizeForAdmin('view', $role);

        $actions = [];
        if($this->authUser->can('index', $role)) {
            $actions[] = ['url' => route('admin.roles.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ];
        }
        if($this->authUser->can('edit', $role)) {
            $actions[] = ['url' => route('admin.roles.edit', ['id' => $role->id]), 'label' => trans('backend/systems.edit'), 'icon' => 'pencil' ];
        }

        $deleteUrl = route('admin.roles.delete', ['id' => $role->id]);

        $data = ['role' => $role, 'actions' => $actions];

        if($this->authUser->can('delete', $role)) {
            $data['deleteUrl'] = $deleteUrl;
        }

        return view('backend.roles.view', $data);
    }

    public function getAdd()
    {
        $role = $this->role->getObject();

        $this->authorizeForAdmin('add', $role);
        if($this->authUser->can('index', $role)) {
            $actions = [
                ['url' => route('admin.roles.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ] 
            ];
        } else {
            $actions = [];
        }

        $checkboxDatas = $this->permission->getAssignList();

        $treeTitle = trans('backend/permissions.index');
        $treeName = 'permissions';

        return view('backend.roles.add', compact('role', 'checkboxDatas', 'treeTitle', 'treeName', 'actions'));
    }

    public function postAdd(RoleRequest $request)
    {
        $role = $this->role->getObject();

        $this->authorizeForAdmin('add', $role);

        DB::beginTransaction();
        try {
            $role = $role->create($request->all());
            if($role == null) {
                throw new ModelSaveFailedException();
            }

            $permissions = $request->permissions;

            $role->permissions()->attach($permissions);

            DB::commit();
            Session::flash('success', trans('backend/messages.save_success', ['entity' => $this->entity]));
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', trans('backend/messages.save_failed', ['entity' => $this->entity]));
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.roles.index');
    }

    public function getEdit($id)
    {
        $role = $this->role->findOrFail($id);

        $this->authorizeForAdmin('edit', $role);

        $actions = [];
        if($this->authUser->can('index', $role)) {
            $actions[] = ['url' => route('admin.roles.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ];
        }
        if($this->authUser->can('view', $role)) {
            $actions[] = ['url' => route('admin.roles.view', ['id' => $role->id]), 'label' => trans('backend/systems.view'), 'icon' => 'eye' ];
        }

        $editMode = true;

        $checkboxDatas = $this->permission->getAssignList();

        $assignedPermission = $role->permissions;

        $checkboxDatas = $checkboxDatas->merge($assignedPermission);

        $checkedDatas = $role->permissions()->getRelatedIds()->toArray();

        $treeTitle = trans('backend/permissions.index');
        $treeName = 'permissions';

        if(! Session::hasOldInput($treeName)) {
            Session::flashInput([$treeName => $checkedDatas]);
        }

        return view('backend.roles.edit', compact(
            'role',
            'checkboxDatas',
            'treeTitle',
            'treeName',
            'checkedDatas',
            'editMode',
            'actions'
        ));
    }

    public function postEdit($id, RoleRequest $request)
    {
        $role = $this->role->findOrFail($id);

        $this->authorizeForAdmin('edit', $role);

        DB::beginTransaction();

        try {
            $updated = $role->update($request->all());
            if(! $updated) {
                throw new ModelSaveFailedException();
            }

            $permissions = $request->permissions;

            $role->permissions()->sync($permissions);

            DB::commit();
            Session::flash('success', trans('backend/messages.save_success', ['entity' => $this->entity]));
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', trans('backend/messages.save_failed', ['entity' => $this->entity]));
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.roles.index');
    }

    public function postDelete($id)
    {
        $role = $this->role->findOrFail($id);
        $this->authorizeForAdmin('delete', $role);

        $result = ['res' => 0, 'error' => trans('backend/messages.delete_failed', ['entity' => $this->entity])];

        DB::beginTransaction();
        try{
            $deleted = $role->delete();

            if($deleted) {
                Session::flash('success', trans('backend/messages.delete_success', ['entity' => $this->entity]));
                $result = ['res' => 1, 'url' => route('admin.roles.index')];
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
                $role = $this->role->findOrFail($value);
                if($this->authUser->can('delete', $role)){
                    $isDeleted = $role->delete();
                    $deleted += $isDeleted ? 1 : 0;
                }
            }
            if($deleted != count($selected)) {
                throw new ModelSaveFailedException();
            }

            DB::commit();
            session()->flash('success', trans('backend/messages.delete_success', ['entity' => $this->entity]));
            $result = ['res' => 1, 'url' => route('admin.roles.index')];
        } catch(Exception $e) {
            DB::rollback();
        }

        return response()->json($result);
    }
}
