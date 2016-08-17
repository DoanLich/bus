@extends('backend.layouts.form', [
    'title' => trans('backend/roles.index'),
    'pageTitle' => trans('backend/roles.index'),
    'formTitle' => trans('backend/systems.edit'),
])

@section('formContent')
    @include('backend.roles._form', ['route' => ['admin.roles.update', $role->id]])
@endsection
