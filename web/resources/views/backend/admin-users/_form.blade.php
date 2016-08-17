{!! Form::model($user, ['route' => $route, 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
    <div class="row">
        <div class="col-md-8">
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
                <label class="control-label col-md-4" for="password">{{ trans('validation.attributes.password') }} 
                    @if (empty($editMode))
                        <span class="required">*</span>
                    @endif
                </label>
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
            @if (!empty($editMode))
                <div class="form-group">
                    <label class="control-label col-md-4" for="status">{{ trans('validation.attributes.status') }}</label>
                    <div class="col-md-8">
                        <div class="radio3 radio-check radio-danger radio-inline">
                            {!! Form::radio('status', config('constant.block_status'), null, ['id' => 'status_block']) !!}
                            <label for="status_block">
                                {{ trans('backend/systems.block') }}
                            </label>
                        </div>
                        <div class="radio3 radio-check radio-success radio-inline">
                            {!! Form::radio('status', config('constant.active_status'), true, ['id' => 'status_active']) !!}
                            <label for="status_active">
                                {{ trans('backend/systems.active') }}
                            </label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label col-md-4" for="avatar">{{ trans('validation.attributes.avatar') }}</label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="kv-avatar text-center" style="width:200px">
                                {!! Form::file('avatar', ['id' => 'avatar']) !!}
                            </div>
                        </div>
                        @if (!empty($editMode))
                            <div class="col-md-6">
                                <img class="img-responsive" src="{{ $user->getAvatar() }}" style="max-width: 200px; max-height: 172px">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item active flat">
                    <span class="badge">{{ $defaultRole->count() }}</span> {{ trans('backend/roles.default') }}
                </li>
                @foreach ($defaultRole as $role)
                    <li class="list-group-item">
                        <span class="badge" style="cursor: pointer" data-trigger="focus" tabindex="0" data-toggle="popover" data-content="{{ $role->description }}" title="{{ trans('backend/roles.description') }}"  data-placement="left"><i class="fa-info fa"></i></span> {{ $role->name }}
                    </li>
                @endforeach
            </ul>
            @include('backend.partial.multi-select')
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">
                <i class="fa-save fa"></i>
                {{ trans('backend/systems.save') }}
            </button>
        </div>
    </div>
{!! Form::close() !!}
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