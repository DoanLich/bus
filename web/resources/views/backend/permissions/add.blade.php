@section('css')
    {!! Html::style('backend/css/permission.css') !!}
@stop

@extends('backend.layouts.form', [
    'title' => trans('backend/permissions.index'),
    'pageTitle' => trans('backend/permissions.index'),
    'formTitle' => trans('backend/systems.add'),
])

@section('formContent')
    @include('backend.permissions._form', ['route' => 'admin.permissions.store'])
@endsection

@section('js-file')
    {!! Html::script('backend/js/permission.js') !!}
@stop
