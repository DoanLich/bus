<?php

namespace App\Http\Controllers\Backend;

use DB;
use Session;
use Exception;
use App\Http\Requests;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\Backend\BusTripRequest;
use App\Repositories\BusTripRepository as BusTrip;
use App\Http\Controllers\Backend\BackendController;

class BusTripController extends BackendController
{
    protected $busTrip;
    protected $entity = 'bus_trip';

    public function __construct(BusTrip $busTrip)
    {
        $this->busTrip = $busTrip;

        parent::__construct();
    }

    private function initDataColumn()
    {
        return [
            ['data' => 'select', 'name' => 'select', 'selectAll' => true, 'sortable' => false, 'searchable' => false, 'width' => '5%' ],
            ['data' => 'id', 'name' => 'id', 'title' => trans('backend/bus_trips.id'), 'searchType' => 'text' ],
            ['data' => 'start_location.name', 'name' => 'startLocation.name', 'title' => trans('backend/bus_trips.start_location'), 'searchType' => 'text' ],
            ['data' => 'end_location.name', 'name' => 'endLocation.name', 'title' => trans('backend/bus_trips.end_location'), 'searchType' => 'text' ],
            ['data' => 'price', 'name' => 'price', 'title' => trans('backend/bus_trips.price'), 'searchType' => 'text' ],
            ['data' => 'start_time', 'name' => 'start_time', 'title' => trans('backend/bus_trips.start_time'), 'searchType' => 'text' ],
            ['data' => 'end_time', 'name' => 'end_time', 'title' => trans('backend/bus_trips.end_time'), 'searchType' => 'text' ],
            ['data' => 'price', 'name' => 'price', 'title' => trans('backend/bus_trips.price'), 'searchType' => 'text' ],
            ['data' => 'status', 'name' => 'status', 'title' => trans('backend/bus_trips.status'), 'sClass' => 'dt-body-center', 'searchType' => 'select', 'searchOption' => config('constant.status_list') ],
            ['data' => 'action', 'name' => 'action', 'title' => trans('backend/systems.action'), 'sortable' => false, 'searchable' => false ]
        ];
    }

    public function index()
    {
        $this->authorizeForAdmin('index', $this->busTrip->getObject());

        if($this->authUser->can('add', $this->busTrip->getObject())) {
            $actions = [
                // ['url' => route('admin.bus_trips.add'), 'label' => trans('backend/systems.add'), 'icon' => 'plus' ] 
            ];
        } else {
            $actions = [];
        }

        $datatables = [
            'columns' => get_datatable_column($this->initDataColumn()),
            'searchColumns' => get_datatable_search_column($this->initDataColumn()),
            'defaultOrder' => get_datatable_default_order($this->initDataColumn()),
        ];

        $deleteSelectedUrl = '';//route('admin.bus_trips.delete_selected');

        return view('backend.bus-trips.index', compact('datatables', 'deleteSelectedUrl', 'actions'));
    }

    public function getBusTripListAsJson(Request $request)
    {
        $this->authorizeForAdmin('index', $this->busTrip->getObject());
        $busTrips = $this->busTrip->getObject()->with(['startLocation', 'endLocation'])->select(['bus_trips.*']);

        $datatable = Datatables::of($busTrips);

        $datatable->addColumn('select', function($row) {
            if($this->authUser->can('delete', $row)) {
                return '<label style="margin-bottom: 0"><input name="datatableSelect" type="checkbox" class="minimal-red datatableSelect" value="'.$row->id.'"></label>';
            }
        });

        $datatable->editColumn('status', function ($row) {
            return '<span class="badge" style="background: '.$row->getStatusColor().'">'.$row->getStatusAsText().'</span>';
        });

        $datatable->editColumn('price', function ($row) {
            return number_format($row->price);
        });

        $datatable->addColumn('action', function($row){
            $buttons = [];
            // if($this->authUser->can('view', $row)) {
            //     $buttons['view'] = ['url' => route('admin.bus_trips.view', ['id' => $row->id])];
            // }
            // if($this->authUser->can('edit', $row)) {
            //     $buttons['edit'] = ['url' => route('admin.bus_trips.edit', ['id' => $row->id])];
            // }
            // if($this->authUser->can('delete', $row)) {
            //     $buttons['delete'] = [
            //         'url' => route('admin.bus_trips.delete', ['id' => $row->id])
            //     ];
            // }

            return (string)view('backend.partial.action', compact('buttons'));
        });

        return $datatable->make(true);
    }
}
