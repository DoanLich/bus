@extends('backend.layouts.list', [
    'title' => trans('backend/bus_trips.index'),
    'pageTitle' => trans('backend/bus_trips.index')
])

@section('listContent')
    @include('backend.partial.datatable', [
        'columns' => $datatables['columns'],
        'searchColumns' => $datatables['searchColumns'],
        'defaultOrder' => $datatables['defaultOrder'],
        'datatableUrl' => route('admin.bus_trips.list_as_json')
    ])
@endsection