@extends('backend.layouts.view', [
    'title' => trans('backend/roles.index'),
    'pageTitle' => trans('backend/roles.index')
])

@section('viewContent')
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/roles.name') }}</label>
        </div>
        <div class="col-md-10">
            <p>{{ $role->name }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/roles.description') }}</label>
        </div>
        <div class="col-md-10">
            <p>{{ $role->description }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/roles.status') }}</label>
        </div>
        <div class="col-md-10">
            <p class="badge" style="background-color: {{ $role->getStatusColor()  }}">{{ $role->getStatusAsText() }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/roles.default') }}</label>
        </div>
        <div class="col-md-10">
            @if ($role->isDefault())
                <i class="fa-check fa success"></i>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/roles.system') }}</label>
        </div>
        <div class="col-md-10">
            @if ($role->isSystem())
                <i class="fa-check fa success"></i>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item active">
                    <span class="badge">{{ $role->permissions()->count() }}</span> {{ trans('backend/permissions.index') }}
                </li>
                @foreach ($role->permissions as $permission)
                    <li class="list-group-item">
                        @if(Auth::guard('admins')->user()->can('view', $permission))
                            <a class="pull-right badge info" style="color: #fff" target="_blank" href="{{ route('admin.permissions.view', ['id' => $permission->id]) }}"><i class="fa-info fa"></i>
                            </a>
                        @endif
                        {{ $permission->name }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item active">
                    <span class="badge">{{ $role->users()->count() }}</span> {{ trans('backend/admin_users.index') }}
                </li>
                @foreach ($role->users as $user)
                    <li class="list-group-item">
                        @if(Auth::guard('admins')->user()->can('view', $user))
                            <a class="pull-right badge info" style="color: #fff" target="_blank" href="{{ route('admin.admin_users.view', ['id' => $user->id]) }}"><i class="fa-info fa"></i>
                            </a>
                        @endif
                        {{ $user->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection