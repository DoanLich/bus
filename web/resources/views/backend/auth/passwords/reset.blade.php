<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ trans('backend/systems.reset_password') }} | {{ config('app.name') }}</title>
    {!! Html::style('css/bootstrap.min.css') !!}
    {!! Html::style('css/font-awesome.min.css') !!}
    {!! Html::style('backend/css/animate.min.css') !!}
    {!! Html::style('backend/css/bootstrap-switch.min.css') !!}
    {!! Html::style('backend/css/checkbox3.min.css') !!}
    {!! Html::style('backend/css/select2.min.css') !!}
    {!! Html::style('backend/css/flat-style.css') !!}
    {!! Html::style('backend/css/flat-green.css') !!}
    {!! Html::style('backend/css/style.css') !!}
    {!! Html::style('backend/css/login.css') !!}
</head>
<body class="flat-green login-page">
    <div class="container">
        <div class="login-box">
            <div>
                <div class="login-form row">
                    <div class="col-sm-12 text-center login-header">
                        <i class="login-logo fa fa-connectdevelop fa-5x"></i>
                        <h4 class="login-title">{{ config('app.name') }}</h4>
                    </div>
                    <div class="col-sm-12">
                        <div class="login-body">
                            @include('backend.partial.error')
                            {!! Form::open(['route' => 'admin.password.reset', 'method' => 'POST']) !!}

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    {!! Form::label('email', trans('validation.attributes.email'), ['class' => 'control-label']) !!}
                                    {!! Form::email('email', $email, ['class' => 'form-control text-center']) !!}
                                </div>
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    {!! Form::label('password', trans('validation.attributes.password'), ['class' => 'control-label']) !!}
                                    {!! Form::password('password', ['class' => 'form-control text-center']) !!}
                                </div>
                                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                    {!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), ['class' => 'control-label']) !!}
                                    {!! Form::password('password_confirmation', ['class' => 'form-control text-center']) !!}
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-block">{{ trans('backend/systems.reset') }}</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partial.alert')

    {!! Html::script('js/jquery-2.2.4.min.js') !!}
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('backend/js/bootstrap-switch.min.js') !!}
    {!! Html::script('backend/js/jquery.matchHeight-min.js') !!}
    {!! Html::script('backend/js/select2.full.min.js') !!}
    {!! Html::script('backend/js/ace.js') !!}
    {!! Html::script('backend/js/mode-html.js') !!}
    {!! Html::script('backend/js/theme-github.js') !!}
    {!! Html::script('backend/js/app.js') !!}
</body>
</html>


