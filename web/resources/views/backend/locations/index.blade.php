@extends('backend.layouts.list', [
    'title' => trans('backend/locations.index'),
    'pageTitle' => trans('backend/locations.index')
])

@section('listContent')
    @include('backend.partial.datatable', [
        'columns' => $datatables['columns'],
        'searchColumns' => $datatables['searchColumns'],
        'defaultOrder' => $datatables['defaultOrder'],
        'datatableUrl' => route('admin.locations.list_as_json')
    ])
@endsection