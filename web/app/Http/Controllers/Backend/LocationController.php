<?php

namespace App\Http\Controllers\Backend;

use DB;
use Session;
use Exception;
use App\Http\Requests;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Exceptions\ModelSaveFailedException;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests\Backend\LocationRequest;
use Yajra\Datatables\Facades\Datatables;

class LocationController extends BackendController
{
    protected $location;
    protected $entity = 'location';

    public function __construct(Location $location)
    {
        $this->location = $location;

        parent::__construct();
    }

    private function initDataColumn()
    {
        return [
            ['data' => 'select', 'name' => 'select', 'selectAll' => true, 'sortable' => false, 'searchable' => false, 'width' => '5%' ],
            ['data' => 'id', 'name' => 'id', 'title' => trans('backend/locations.id'), 'searchType' => 'text' ],
            ['data' => 'name', 'name' => 'name', 'title' => trans('backend/locations.name'), 'searchType' => 'text' ],
            ['data' => 'action', 'name' => 'action', 'title' => trans('backend/systems.action'), 'sortable' => false, 'searchable' => false ]
        ];
    }

    public function index()
    {
        $this->authorizeForAdmin('index', $this->location);

        if($this->authUser->can('add', $this->location)) {
            $actions = [
                ['url' => route('admin.locations.add'), 'label' => trans('backend/systems.add'), 'icon' => 'plus' ] 
            ];
        } else {
            $actions = [];
        }

        $datatables = [
            'columns' => get_datatable_column($this->initDataColumn()),
            'searchColumns' => get_datatable_search_column($this->initDataColumn()),
            'defaultOrder' => get_datatable_default_order($this->initDataColumn()),
        ];

        $deleteSelectedUrl = route('admin.locations.delete_selected');

        return view('backend.locations.index', compact('datatables', 'deleteSelectedUrl', 'actions'));
    }

    public function getLocationListAsJson(Request $request)
    {
        $this->authorizeForAdmin('index', $this->location);
        $locations = $this->location->select(['*']);

        $datatable = Datatables::of($locations);

        $datatable->addColumn('select', function($row) {
            if($this->authUser->can('delete', $row)) {
                return '<label style="margin-bottom: 0"><input name="datatableSelect" type="checkbox" class="minimal-red datatableSelect" value="'.$row->id.'"></label>';
            }
        });

        $datatable->addColumn('action', function($row){
            $buttons = [];
            if($this->authUser->can('view', $row)) {
                $buttons['view'] = ['url' => route('admin.locations.view', ['id' => $row->id])];
            }
            if($this->authUser->can('edit', $row)) {
                $buttons['edit'] = ['url' => route('admin.locations.edit', ['id' => $row->id])];
            }
            if($this->authUser->can('delete', $row)) {
                $buttons['delete'] = [
                    'url' => route('admin.locations.delete', ['id' => $row->id])
                ];
            }

            return (string)view('backend.partial.action', compact('buttons'));
        });

        return $datatable->make(true);
    }

    public function getView($id)
    {
        $location = $this->location->findOrFail($id);
        $this->authorizeForAdmin('view', $location);

        $actions = [];
        if($this->authUser->can('index', $location)) {
            $actions[] = ['url' => route('admin.locations.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ];
        }
        if($this->authUser->can('edit', $location)) {
            $actions[] = ['url' => route('admin.locations.edit', ['id' => $location->id]), 'label' => trans('backend/systems.edit'), 'icon' => 'pencil' ];
        }

        $deleteUrl = route('admin.locations.delete', ['id' => $location->id]);

        $data = ['location' => $location, 'actions' => $actions];

        if($this->authUser->can('delete', $location)) {
            $data['deleteUrl'] = $deleteUrl;
        }

        return view('backend.locations.view', $data);
    }

    public function getAdd()
    {
        $location = $this->location;
        $this->authorizeForAdmin('add', $location);
        if($this->authUser->can('index', $location)) {
            $actions = [
                ['url' => route('admin.locations.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ] 
            ];
        } else {
            $actions = [];
        }

        return view('backend.locations.add', compact('location', 'actions'));
    }

    public function postAdd(LocationRequest $request)
    {
        $location = $this->location;
        $this->authorizeForAdmin('add', $location);

        DB::beginTransaction();

        try {
            $location = $location->create($request->all());
            if($location == null) {
                throw new ModelSaveFailedException();
            }
            DB::commit();
            Session::flash('success', trans('backend/messages.save_success', ['entity' => trans('entities.'.$this->entity)]));
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', trans('backend/messages.save_failed', ['entity' => trans('entities.'.$this->entity)]));
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.locations.index');
    }

    public function getEdit($id)
    {
        $location = $this->location->findOrFail($id);
        $this->authorizeForAdmin('edit', $location);
        $actions = [];
        if($this->authUser->can('index', $location)) {
            $actions[] = ['url' => route('admin.locations.index'), 'label' => trans('backend/systems.list'), 'icon' => 'list' ];
        }
        if($this->authUser->can('view', $location)) {
            $actions[] = ['url' => route('admin.locations.view', ['id' => $location->id]), 'label' => trans('backend/systems.view'), 'icon' => 'eye' ];
        }

        return view('backend.locations.edit', compact('location', 'actions'));
    }

    public function postEdit($id, LocationRequest $request)
    {
        $location = $this->location->findOrFail($id);
        $this->authorizeForAdmin('edit', $location);

        DB::beginTransaction();

        try {
            $udpated = $location->update($request->all());
            if(!$udpated) {
                throw new ModelSaveFailedException();
            }
            DB::commit();
            Session::flash('success', trans('backend/messages.save_success', ['entity' => trans('entities.'.$this->entity)]));
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', trans('backend/messages.save_failed', ['entity' => trans('entities.'.$this->entity)]));
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.locations.index');
    }

    public function postDelete($id)
    {
        $location = $this->location->findOrFail($id);
        $this->authorizeForAdmin('delete', $location);

        $result = ['res' => 0, 'error' => trans('backend/messages.delete_failed', ['entity' => trans('entities.'.$this->entity)])];

        DB::beginTransaction();
        try{
            $deleted = $location->delete();

            if($deleted) {
                Session::flash('success', trans('backend/messages.delete_success', ['entity' => trans('entities.'.$this->entity)]));
                $result = ['res' => 1, 'url' => route('admin.locations.index')];
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

        $result = ['res' => 0, 'error' => trans('backend/messages.delete_failed', ['entity' => trans('entities.'.$this->entity)])];

        DB::beginTransaction();
        try {
            $deleted = 0;
            foreach ($selected as $value) {
                $location = $this->location->findOrFail($value);
                if($this->authUser->can('delete', $location)){
                    $isDeleted = $location->delete();
                    $deleted += $isDeleted ? 1 : 0;
                }
            }
            if($deleted != count($selected)) {
                throw new ModelSaveFailedException();
            }

            DB::commit();
            session()->flash('success', trans('backend/messages.delete_success', ['entity' => trans('entities.'.$this->entity)]));
            $result = ['res' => 1, 'url' => route('admin.locations.index')];
        } catch(Exception $e) {
            DB::rollback();
        }

        return response()->json($result);
    }
}
