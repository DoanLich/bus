{!! Form::model($location, ['route' => $route, 'method' => 'POST', 'class' => 'form-horizontal']) !!}
    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        <label class="control-label col-lg-4 col-md-4" for="name">{{ trans('validation.attributes.name') }} <span class="required">*</span></label>
        <div class="col-lg-8 col-md-8">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.name')]) !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-8 col-md-8 col-lg-offset-4 col-md-offset-4">
            {!! Form::submit(trans('backend/systems.save'), ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
{!! Form::close() !!}