@extends('backend.layouts.form', [
    'title' => trans('backend/systems.profile'),
    'formTitle' => trans('backend/systems.profile'),
])

@section('formContent')
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
                <div class="card-footer">
                    @foreach ($user->getRole() as $role)
                        <p class="badge warning">{{ $role->name }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            {!! Form::model($user, ['route' => 'admin.profile', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                    <label class="control-label col-md-4" for="name">{{ trans('validation.attributes.name') }} <span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.name')]) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                    <label class="control-label col-md-4" for="email">{{ trans('validation.attributes.email') }} <span class="required">*</span></label>
                    <div class="col-md-8">
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                    <label class="control-label col-md-4" for="password">{{ trans('validation.attributes.password') }} </label>
                    <div class="col-md-8">
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('validation.attributes.password')]) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                    <label class="control-label col-md-4" for="password_confirmation">{{ trans('validation.attributes.password_confirmation') }}</label>
                    <div class="col-md-8">
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('validation.attributes.password_confirmation')]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" for="avatar">{{ trans('validation.attributes.avatar') }}</label>
                    <div class="col-md-8">
                        <div class="kv-avatar text-center" style="width:200px">
                            {!! Form::file('avatar', ['id' => 'avatar']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-save fa"></i>
                            {{ trans('backend/systems.save') }}
                        </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('form-js')
    $(document).ready(function () {
        $("#avatar").fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showUpload: false,
            showClose: false,
            showCaption: false,
            browseLabel: '',
            removeLabel: '',
            browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            defaultPreviewContent: '<img src="/images/300x300.png" style="width:160px">',
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    });
    @parent
@endsection