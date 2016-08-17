@extends('backend.layouts.list', [
    'title' => trans('backend/admin_users.index'),
    'pageTitle' => trans('backend/admin_users.index')
])

@section('listContent')
    @include('backend.partial.datatable', [
        'columns' => $datatables['columns'],
        'searchColumns' => $datatables['searchColumns'],
        'defaultOrder' => $datatables['defaultOrder'],
        'datatableUrl' => route('admin.admin_users.list_as_json')
    ])
@endsection