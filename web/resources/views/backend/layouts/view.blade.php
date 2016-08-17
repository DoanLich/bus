@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">{{ $viewTitle or trans('backend/systems.view') }}</div>
                    </div>
                        <div class="pull-right card-action">
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa-flash fa"></i> {{ trans('backend/systems.action') }} <span class="caret"></span></button>
                                <ul class="dropdown-menu pull-right animated fadeIn">
                                    @if(!empty($actions))
                                        @foreach($actions as $action)
                                            <li><a href="{{ $action['url'] }}"><i class="fa fa-{{ isset($action['icon']) ? $action['icon'] : 'hand-o-right' }}"></i> {{ $action['label'] }}</a></li>
                                        @endforeach
                                    @endif
                                    @if(isset($deleteUrl))
                                        <li>
                                            <a href="{{ $deleteUrl }}" data-confirm="{{ trans('backend/systems.confirm_delete') }}" onclick="return confirmAction(this)"><i class="fa-trash fa"></i> {{ trans('backend/systems.delete') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                </div>
                <div class="card-body">
                    @yield('viewContent')
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    @yield('view-js')
@stop