@extends('backend.layouts.form', [
    'title' => trans('backend/admin_users.index'),
    'pageTitle' => trans('backend/admin_users.index'),
    'formTitle' => trans('backend/systems.edit'),
])

@section('formContent')
    @include('backend.admin-users._form', ['route' => ['admin.admin_users.update', $user->id]])
@endsection
