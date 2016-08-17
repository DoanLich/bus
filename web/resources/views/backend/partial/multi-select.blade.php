@section('css-file')
    {!! Html::style('backend/css/multiselect.css') !!}
    @parent
@endsection
{{--*/ $checkboxName = isset($treeName) ? $treeName : 'tree_checkbox' /*--}}
<div class="multiselect">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="title"><i class="fa fa-check-square-o"></i> {{ $treeTitle or 'Tree multiselect' }}</div>
            </div>
            <div class="card-action pull-right">
                <span id="select-all" data-toggle="tooltip" title="Select all" data-placement="left" class="btn-default btn"><i class="fa-check-square fa text-success"></i></span>
                <span id="unselect-all" data-toggle="tooltip" title="Unselect all" data-placement="left" class="btn-default btn"><i class="fa-minus-square fa text-danger"></i></span>
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="card-body no-padding">
            <div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="selection">
                            {{--*/ $group = '' /*--}}
                            {{--*/ $isOpen = false /*--}}
                            @foreach ($checkboxDatas as $checkboxData)
                                @if (empty($checkboxData['group']))
                                    @if ($isOpen)
                                                <!-- End each group -->
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="checkbox3 checkbox-check checkbox-light">
                                        <input data-content="{{ $checkboxData['name'] }}" onclick="processClick(this)" {{ !empty(old($checkboxName)) && in_array($checkboxData['id'], old($checkboxName)) ? 'checked' : (!empty(old($checkboxName)) ? '' : (!empty($checkedDatas) && in_array($checkboxData['id'], $checkedDatas) ? 'checked' : ''))  }} name="{{ $checkboxName . '[]' }}" type="checkbox" id="{{ $checkboxData['id'] }}" value="{{ $checkboxData['id'] }}">
                                        <label for="{{ $checkboxData['id'] }}" data-toggle="tooltip" title="{{ $checkboxData['description'] }}">
                                            {{ $checkboxData['name'] }}
                                        </label>
                                    </div>
                                    {{--*/ $isOpen = false /*--}}
                                    {{--*/ $group = '' /*--}}
                                @else
                                    @if ($checkboxData['group'] == $group)
                                        <div class="checkbox3 checkbox-check checkbox-success checkbox-light">
                                            <input data-content="{{ $checkboxData['name'] }}" onclick="processClick(this)" data-parent="{{ $checkboxData['group'] }}" {{ !empty(old($checkboxName)) && in_array($checkboxData['id'], old($checkboxName)) ? 'checked' : (!empty(old($checkboxName)) ? '' : (!empty($checkedDatas) && in_array($checkboxData['id'], $checkedDatas) ? 'checked' : ''))  }} name="{{ $checkboxName . '[]' }}" type="checkbox" id="{{ $checkboxData['id'] }}" value="{{ $checkboxData['id'] }}">
                                            <label for="{{ $checkboxData['id'] }}" data-toggle="tooltip" title="{{ $checkboxData['description'] }}">
                                                {{ $checkboxData['name'] }}
                                            </label>
                                        </div>
                                    @else
                                        @if ($isOpen)
                                                    <!-- End each group -->
                                                    </div>
                                                </div>
                                            </div>
                                            {{--*/ $isOpen = false /*--}}
                                        @endif
                                        <!-- Start each group -->
                                        <div>
                                            <div class="title">
                                                <div class="title-checkbox checkbox3 checkbox-check checkbox-light">
                                                    <input onclick="processParentClick(this)" value="{{ $checkboxData['group'] }}" type="checkbox" id="checkbox-{{ $checkboxData['group'] }}">
                                                    <label for="checkbox-{{ $checkboxData['group'] }}">
                                                        {{ $checkboxData['group'] }}
                                                    </label>
                                                </div>
                                                <span data-toggle="collapse" data-target="#{{ $checkboxData['group'] }}" aria-expanded="false" aria-controls="collapseExample" class="count collapsed"><i class="fa-chevron-circle-up fa text-info"></i></span>
                                            </div>
                                            <div class="item">
                                                <div class="collapse" id="{{ $checkboxData['group'] }}">
                                                    <div class="checkbox3 checkbox-check checkbox-success checkbox-light">
                                                        <input data-content="{{ $checkboxData['name'] }}" onclick="processClick(this)" data-parent="{{ $checkboxData['group'] }}" {{ !empty(old($checkboxName)) && in_array($checkboxData['id'], old($checkboxName)) ? 'checked' : (!empty(old($checkboxName)) ? '' : (!empty($checkedDatas) && in_array($checkboxData['id'], $checkedDatas) ? 'checked' : ''))  }} name="{{ $checkboxName . '[]' }}" type="checkbox" id="{{ $checkboxData['id'] }}" value="{{ $checkboxData['id'] }}">
                                                        <label for="{{ $checkboxData['id'] }}">
                                                            <span data-toggle="tooltip" title="{{ $checkboxData['description'] }}">{{ $checkboxData['name'] }}</span>
                                                        </label>
                                                    </div>

                                        {{--*/ $group = $checkboxData['group'] /*--}}
                                        {{--*/ $isOpen = true /*--}}
                                    @endif
                                @endif
                            @endforeach
                            @if ($isOpen)
                                        </div>
                                    </div>
                                </div>
                                {{--*/ $isOpen = false /*--}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="selected">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js-file')
    {!! Html::script('backend/js/multiselect.js') !!}
    @parent
@endsection
@section('js')
    checkboxName = '{{ $checkboxName }}';
    @parent
@endsection