@extends('backend.layouts.form', [
    'title' => trans('backend/roles.index'),
    'pageTitle' => trans('backend/roles.index'),
    'formTitle' => trans('backend/systems.add'),
])

@section('formContent')
    @include('backend.roles._form', ['route' => 'admin.roles.store'])
@endsection
