@extends('backend.layouts.form', [
    'pageTitle' => trans('backend/users.index'),
    'formTitle' => trans('backend/systems.add'),
])

@section('formContent')
	{!! Form::open(['route' => 'admin.users.store', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal']) !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        			<label class="control-label col-lg-4 col-md-4" for="name">{{ trans('validation.attributes.name') }} <span class="required">*</span></label>
        			<div class="col-lg-8 col-md-8">
        				{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.name')]) !!}
        			</div>
        		</div>
        		<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
        			<label class="control-label col-lg-4 col-md-4" for="email">{{ trans('validation.attributes.email') }} <span class="required">*</span></label>
        			<div class="col-lg-8 col-md-8">
        				{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
        			</div>
        		</div>
        		<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
        			<label class="control-label col-lg-4 col-md-4" for="password">{{ trans('validation.attributes.password') }} <span class="required">*</span></label>
        			<div class="col-lg-8 col-md-8">
        				{!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('validation.attributes.password')]) !!}
        			</div>
        		</div>
        		<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
        			<label class="control-label col-lg-4 col-md-4" for="password_confirmation">{{ trans('validation.attributes.password_confirmation') }} <span class="required">*</span></label>
        			<div class="col-lg-8 col-md-8">
        				{!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('validation.attributes.password_confirmation')]) !!}
        			</div>
        		</div>
        		<div class="form-group">
        			<div class="col-lg-8 col-md-8 col-lg-offset-4 col-md-offset-4">
        				{!! Form::submit(trans('backend/systems.save'), ['class' => 'btn btn-primary']) !!}
        			</div>
        		</div>
            </div>
        </div>
	{!! Form::close() !!}
@endsection
