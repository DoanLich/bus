@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">{{ $formTitle or trans('backend/systems.form') }}</div>
                </div>
                @if(!empty($actions))
                    <div class="pull-right card-action">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa-flash fa"></i> {{ trans('backend/systems.action') }} <span class="caret"></span></button>
                            <ul class="dropdown-menu pull-right animated fadeIn">
                                @foreach($actions as $action)
                                    <li><a href="{{ $action['url'] }}"><i class="fa fa-{{ isset($action['icon']) ? $action['icon'] : 'hand-o-right' }}"></i> {{ $action['label'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-body">
                @include('backend.partial.error')
            	@yield('formContent')
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    @yield('form-js')
    @parent
@endsection