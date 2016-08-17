<?php

namespace App\Http\Controllers\Backend;

use DB;
use Auth;
use Session;
use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Exceptions\ModelSaveFailedException;
use App\Http\Requests\Backend\PermissionRequest;
use App\Http\Controllers\Backend\BackendController;
use App\Repositories\PermissionRepository as Permission;

class PermissionController extends BackendController
{
    private $permission;
    private $entity = 'permission';

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;

        parent::__construct();
    }

    private function initDataColumn()
    {
        return [
            ['data' => 'select', 'name' => 'select', 'selectAll' => true, 'sortable' => false, 'searchable' => false, 'width' => '5%' ],
            ['data' => 'id', 'name' => 'id', 'title' => trans('backend/permissions.id'), 'searchType' => 'text' ],
            ['data' => 'index', 'name' => 'index', 'title' => trans('backend/permissions.index_field'), 'searchType' => 'text' ],
            ['data' => 'name', 'name' => 'name', 'title' => trans('backend/permissions.name'), 'searchType' => 'text' ],
            ['data' => 'status', 'name' => 'status', 'title' => trans('backend/permissions.status'), 'sClass' => 'dt-body-center', 'searchType' => 'select', 'searchOption' => config('constant.status_list') ],
            ['data' => 'group', 'name' => 'group', 'title' => trans('backend/permissions.group'), 'searchType' => 'text' ],
            ['data' => 'action', 'name' => 'action', 'title' => trans('backend/systems.action'), 'sortable' => false, 'searchable' => false ]
        ];
    }

    public function index()
    {
        $this->authorizeForAdmin('index', $this->permission->getObject());

        if($this->authUser->can('add', $this->permission->getObject())) {
            $actions = [
                ['url' => route('admin.permissions.add'), 'label' => trans('backend/systems.add'), 'icon' => 'plus' ] 
            ];
        } else {
            $actions = [];
        }

        $datatables = [
            'columns' => get_datatable_column($this->initDataColumn()),
            'searchColumns' => get_datatable_search_column($this->initDataColumn()),
            'defaultOrder' => get_datatable_default_order($this->initDataColumn()),
        ];

        $deleteSelectedUrl = route('admin.permissions.delete_selected');

        return view('backend.permissions.index', compact('datatables', 'deleteSelectedUrl', 'actions'));
    }

    public function getPermissionListAsJson(Request $request)
    {
        $this->authorizeForAdmin('index', $this->permission->getObject());
        $permissions = $this->permission->getObject()->select(['*']);

        $datatable = Datatables::of($permissions);

        $datatable->editColumn('status', function ($row) {
            return '<span class="badge" style="background: '.$row->getStatusColor().'">'.$row->getStatusAsText().'</span>';
        });

        $datatable->addColumn('select', function($row) {
            if($this->authUser->can('delete', $row)) {
                return '<label style="margin-bottom: 0"><input name="datatableSelect" type="checkbox" class="minimal-red datatableSelect" value="'.$row->id.'"></label>';
            }
        });

        $datatable->addColumn('action', function($row){
            $buttons = [];
            if($this->authUser->can('view', $row)) {
                $buttons['view'] = ['url' => route('admin.permissions.view', ['id' => $row->id])];
            }
            if($this->authUser->can('edit', $row)) {
                $buttons['edit'] = ['url' => route('admin.permissions.edit', ['id' => $row->id])];
            }
            if($this->authUser->can('delete', $row)) {
                $buttons['delete'] = [
                    'url' => route('admin.permissions.delete', ['id' => $row->id])
                ];
            }

            return (string)view('backend.partial.action', compact('buttons'));
        });

        return $datatable->make(true);
    }

    public function getView($id)
    {
        $permission = $this->permission->findOrFail($id);
        $this->authorizeForAdmin('view', $permission);

        $actions = [];
        if($this->authUser->can('index', $this->permission->getObject())) {
            $actions[] = ['url' => route('admin.permissions.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ];
        }
        if($this->authUser->can('edit', $permission)) {
            $actions[] = ['url' => route('admin.permissions.edit', ['id' => $permission->id]), 'label' => trans('backend/systems.edit'), 'icon' => 'pencil' ];
        }

        $deleteUrl = route('admin.permissions.delete', ['id' => $permission->id]);

        $data = ['permission' => $permission, 'actions' => $actions];

        if($this->authUser->can('delete', $permission)) {
            $data['deleteUrl'] = $deleteUrl;
        }

        return view('backend.permissions.view', $data);
    }

    public function getAdd()
    {
        $permission = $this->permission->getObject();
        $this->authorizeForAdmin('add', $permission);

        if($this->authUser->can('index', $this->permission->getObject())) {
            $actions = [
                ['url' => route('admin.permissions.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ]
            ];
        } else {
            $actions = [];
        }

        $editMode = false;

        $groups = $this->permission->getObject()->where('group', '<>', '')->lists('group', 'group');
        $groups['-1'] = trans('backend/systems.other');

        $parentLists = $this->permission->getObject()->lists('name', 'id');

        return view('backend.permissions.add', compact(
            'permission',
            'groups',
            'parentLists',
            'editMode',
            'actions'
        ));
    }

    public function postAdd(PermissionRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['parent_id'] = $data['parent_id'] == null ? NULL : $data['parent_id'];
            $data['group'] = $data['group'] == -1 ? $data['other_group'] : $data['group'];

            $permission = $this->permission->create($data);

            if($permission == null) {
                throw new ModelSaveFailedException();
            }

            DB::commit();
            Session::flash('success', trans('backend/messages.save_success', ['entity' => $this->entity]));
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            Session::flash('error', trans('backend/messages.save_failed', ['entity' => $this->entity]));
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.permissions.index');
    }

    public function getEdit($id)
    {
        $permission = $this->permission->findOrFail($id);
        $this->authorizeForAdmin('edit', $permission);

        $actions = [];
        if($this->authUser->can('index', $this->permission->getObject())) {
            $actions[] = ['url' => route('admin.permissions.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ];
        }
        if($this->authUser->can('view', $permission)) {
            $actions[] = ['url' => route('admin.permissions.view', ['id' => $permission->id]), 'label' => trans('backend/systems.view'), 'icon' => 'eye' ];
        }

        $editMode = true;

        $groups = $this->permission->getObject()->where('group', '<>', '')->lists('group', 'group');
        $groups['-1'] = trans('backend/systems.other');

        $parentLists = $this->permission->getObject()->lists('name', 'id');

        return view('backend.permissions.edit', compact(
            'permission',
            'groups',
            'parentLists',
            'editMode',
            'actions'
        ));
    }

    public function postEdit($id, PermissionRequest $request)
    {
        DB::beginTransaction();
        try {
            $permission = $this->permission->findOrFail($id);
            $data = $request->all();
            $data['parent_id'] = $data['parent_id'] == null ? NULL : $data['parent_id'];
            $data['group'] = $data['group'] == -1 ? $data['other_group'] : $data['group'];

            $permission = $permission->update($data);

            if(!$permission) {
                throw new ModelSaveFailedException();
            }

            DB::commit();
            Session::flash('success', trans('backend/messages.save_success', ['entity' => $this->entity]));
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            Session::flash('error', trans('backend/messages.save_failed', ['entity' => $this->entity]));
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.permissions.index');
    }

    public function postDelete($id)
    {
        $permission = $this->permission->findOrFail($id);
        $this->authorizeForAdmin('delete', $permission);

        $result = ['res' => 0, 'error' => trans('backend/messages.delete_failed', ['entity' => $this->entity])];

        DB::beginTransaction();
        try{
            $deleted = $permission->delete();

            if($deleted) {
                Session::flash('success', trans('backend/messages.delete_success', ['entity' => $this->entity]));
                $result = ['res' => 1, 'url' => route('admin.permissions.index')];
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
                $permission = $this->permission->findOrFail($value);
                if($this->authUser->can('delete', $permission)){
                    $isDeleted = $permission->delete();
                    $deleted += $isDeleted ? 1 : 0;
                }
            }
            if($deleted != count($selected)) {
                throw new ModelSaveFailedException();
            }

            DB::commit();
            session()->flash('success', trans('backend/messages.delete_success', ['entity' => $this->entity]));
            $result = ['res' => 1, 'url' => route('admin.permissions.index')];
        } catch(Exception $e) {
            DB::rollback();
        }

        return response()->json($result);
    }
}
