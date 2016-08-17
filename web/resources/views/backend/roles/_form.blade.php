{!! Form::model($role, ['route' => $route, 'method' => 'POST', 'class' => 'form-horizontal']) !!}
    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        <label class="control-label col-md-4" for="name">{{ trans('validation.attributes.name') }} <span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.name')]) !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
        <label class="control-label col-md-4" for="description">{{ trans('validation.attributes.description') }}</label>
        <div class="col-md-8">
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.description'), 'rows' => 3]) !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('default') ? 'has-error' : ''}}">
        <div class="col-md-8 col-md-offset-4">
            <div class="checkbox3 checkbox-danger checkbox-inline checkbox-check  checkbox-circle checkbox-light">
                {!! Form::checkbox('default', 1, null, ['id' => 'checkbox-default']) !!}
                <label for="checkbox-default">
                    {{ trans('validation.attributes.default') }}
                </label>
            </div>
        </div>
    </div>
    @if (isset($editMode) && $editMode)
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
        <div class="col-md-8 col-md-offset-4">
            @include('backend.partial.multi-select')
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-8 col-md-offset-4">
            {!! Form::submit(trans('backend/systems.save'), ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
{!! Form::close() !!}