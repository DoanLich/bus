@extends('backend.layouts.view', [
    'title' => trans('backend/admin_users.index'),
    'pageTitle' => trans('backend/admin_users.index')
])

@section('viewContent')
<div class="row no-margin">
    <div class="col-sm-3">
        <div class="card profile">
            <div class="card-profile-img">
                <img src="{{ $user->getAvatar() }}">
            </div>
            <div class="card-footer">
                {{ $user->name }}
            </div>
            <div class="card-footer">
                {{ $user->email }}
            </div>
            <div class="card-footer">
                <p class="badge" style="background-color: {{ $user->getStatusColor()  }}">{{ $user->getStatusAsText() }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <ul class="list-group">
            <li class="list-group-item active">
                <span class="badge">{{ $user->roles()->count() }}</span> {{ trans('backend/roles.index') }}
            </li>
            @foreach ($user->getRole() as $role)
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
</div>
@endsection