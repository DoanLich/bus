@extends('backend.layouts.form', [
    'title' => trans('backend/locations.index'),
    'pageTitle' => trans('backend/locations.index'),
    'formTitle' => trans('backend/systems.add'),
])

@section('formContent')
    @include('backend.locations._form', ['route' => 'admin.locations.store'])
@endsection