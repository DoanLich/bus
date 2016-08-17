@extends('backend.layouts.view', [
    'title' => trans('backend/permissions.index'),
    'pageTitle' => trans('backend/permissions.index')
])

@section('viewContent')
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/permissions.index') }}</label>
        </div>
        <div class="col-md-10">
            <p>{{ $permission->index }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/permissions.name') }}</label>
        </div>
        <div class="col-md-10">
            <p>{{ $permission->name }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/permissions.status') }}</label>
        </div>
        <div class="col-md-10">
            <p class="badge" style="background-color: {{ $permission->getStatusColor()  }}">{{ $permission->getStatusAsText() }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/permissions.description') }}</label>
        </div>
        <div class="col-md-10">
            <p>{{ $permission->description }}</p>
        </div>
    </div>
    <div>
        <ul class="list-group">
            <li class="list-group-item active">
                <span class="badge">{{ $permission->roles()->count() }}</span> {{ trans('backend/roles.index') }}
            </li>
            @foreach ($permission->roles as $role)
                <li class="list-group-item">
                    @if(Auth::guard('admins')->user()->can('view', $role))
                        <a class="pull-right badge info" style="color: #fff" target="_blank" href="{{ route('admin.roles.view', ['id' => $role->id]) }}"><i class="fa-info fa"></i>
                        </a>
                    @endif
                    {{ $role->name }}
                </li>
            @endforeach
        </ul>
    </div>
@endsection