@extends('backend.layouts.list', [
    'title' => trans('backend/permissions.index'),
    'pageTitle' => trans('backend/permissions.index')
])

@section('listContent')
    @include('backend.partial.datatable', [
        'columns' => $datatables['columns'],
        'searchColumns' => $datatables['searchColumns'],
        'defaultOrder' => $datatables['defaultOrder'],
        'datatableUrl' => route('admin.permissions.list_as_json')
    ])
@endsection