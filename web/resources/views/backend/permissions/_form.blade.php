{!! Form::model($permission, ['route' => $route, 'method' => 'POST', 'class' => 'form-horizontal']) !!}
    <div class="form-group {{ $errors->has('index') ? 'has-error' : ''}}">
        <label class="control-label col-lg-4 col-md-4" for="index">{{ trans('validation.attributes.index') }} <span class="required">*</span></label>
        <div class="col-lg-8 col-md-8">
            {!! Form::text('index', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.index')]) !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        <label class="control-label col-lg-4 col-md-4" for="name">{{ trans('validation.attributes.name') }} <span class="required">*</span></label>
        <div class="col-lg-8 col-md-8">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.name')]) !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
        <label class="control-label col-lg-4 col-md-4" for="description">{{ trans('validation.attributes.description') }}</label>
        <div class="col-lg-8 col-md-8">
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.description'), 'rows' => 3]) !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : ''}}">
        <label class="control-label col-lg-4 col-md-4" for="parent_id">{{ trans('validation.attributes.parent') }}</label>
        <div class="col-lg-8 col-md-8">
            {!! Form::select('parent_id', $parentLists, null, ['class' => 'form-control select2', 'placeholder' => trans('backend/systems.select_option')]) !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('group') ? 'has-error' : ''}}">
        <label class="control-label col-lg-4 col-md-4" for="group">{{ trans('validation.attributes.group') }}</label>
        <div class="col-lg-8 col-md-8">
            {!! Form::select('group', $groups, null, ['class' => 'form-control select2', 'placeholder' => trans('backend/systems.select_option'), 'id' => 'permission_group']) !!}
            {!! Form::text('other_group', null, ['class' => 'form-control other-group', 'placeholder' => trans('validation.attributes.other_group'), 'id' => 'permission_other_group']) !!}
        </div>
    </div>
    @if ($editMode)
        <div class="form-group">
            <label class="control-label col-lg-4 col-md-4" for="status">{{ trans('validation.attributes.status') }}</label>
            <div class="col-lg-8 col-md-8">
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
        <div class="col-lg-8 col-md-8 col-lg-offset-4 col-md-offset-4">
            {!! Form::submit(trans('backend/systems.save'), ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
{!! Form::close() !!}