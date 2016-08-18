@extends('backend.layouts.view', [
    'title' => trans('backend/locations.index'),
    'pageTitle' => trans('backend/locations.index')
])

@section('viewContent')
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/locations.id') }}</label>
        </div>
        <div class="col-md-10">
            <p>{{ $location->id }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label>{{ trans('backend/locations.name') }}</label>
        </div>
        <div class="col-md-10">
            <p>{{ $location->name }}</p>
        </div>
    </div>
@endsection