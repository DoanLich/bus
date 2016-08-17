@extends('backend.layouts.list', [
    'title' => trans('backend/roles.index'),
    'pageTitle' => trans('backend/roles.index')
])

@section('listContent')
    @include('backend.partial.datatable', [
        'columns' => $datatables['columns'],
        'searchColumns' => $datatables['searchColumns'],
        'defaultOrder' => $datatables['defaultOrder'],
        'datatableUrl' => route('admin.roles.list_as_json')
    ])
@endsection