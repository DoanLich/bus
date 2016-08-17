@extends('backend.layouts.app', [
    'title' => trans('backend/logs.index')
])

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="title">{{ trans('backend/logs.index') }}</div>
            </div>
        </div>
        <div class="card-body no-padding">
            <div role="tabpanel" class="tab">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    @foreach ($files as $file)
                        <li class="@if ($current_file == $file) active @endif">
                            <a href="?file={{ base64_encode($file) }}"> {{$file}} </a>
                        </li>
                    @endforeach
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active">
                        @if ($logs === null)
                        <div class="alert alert-info fresh-color">
                            {{ trans('backend/logs.hint', ['size' => $max]) }}
                        </div>
                        @else
                        <table id="table-log" class="table table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>{{ trans('backend/logs.level') }}</th>
                                    <th>{{ trans('backend/logs.context') }}</th>
                                    <th>{{ trans('backend/logs.date') }}</th>
                                    <th>{{ trans('backend/logs.content') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $key => $log)
                                <tr>
                                    <td class="text-{{{$log['level_class']}}}"><span class="glyphicon glyphicon-{{{$log['level_img']}}}-sign" aria-hidden="true"></span> &nbsp;{{$log['level']}}</td>
                                    <td class="text">{{$log['context']}}</td>
                                    <td class="date">{{{$log['date']}}}</td>
                                    <td class="text">
                                        @if ($log['stack']) <a class="pull-right expand btn btn-default btn-xs" data-display="stack{{{$key}}}"><span class="glyphicon glyphicon-search"></span></a>@endif
                                        {{{$log['text']}}}
                                        @if (isset($log['in_file'])) <br />{{{$log['in_file']}}}@endif
                                        @if ($log['stack']) 
                                        <div class="stack" id="stack{{{$key}}}" style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}</div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        <div>
                            <a class="btn btn-default" href="?download={{ base64_encode($current_file) }}"><span class="glyphicon glyphicon-download-alt"></span> {{ trans('backend/logs.download_file') }}</a>
                            <a class="btn btn-danger" onclick="return confirmAction(this)" id="delete-log" href="?delete={{ base64_encode($current_file) }}"><span class="glyphicon glyphicon-trash"></span> {{ trans('backend/logs.delete_file') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    $(document).ready(function(){
        $('#table-log').DataTable({
            "order": [ 1, 'desc' ],
            "stateSave": true,
            "stateSaveCallback": function (settings, data) {
                window.localStorage.setItem("datatable", JSON.stringify(data));
            },
            "stateLoadCallback": function (settings) {
                var data = JSON.parse(window.localStorage.getItem("datatable"));
                if (data) data.start = 0;
                return data;
            },
            "oLanguage": {
                "oPaginate": {
                    "sNext": "{{ trans('pagination.next') }}",
                    "sPrevious": "{{ trans('pagination.previous') }}"
                },
                "sInfo": "{{ trans('backend/datatables.sInfo') }}",
                sLengthMenu: "{{ trans('backend/datatables.sLengthMenu') }}",
                sSearch: "{{ trans('backend/datatables.sSearch') }}",
                sProcessing: '<img src="{{ url('images/loading.gif') }}">',
            },
        });
        $('#table-log').on('click', '.expand', function(){
            $('#common-modal .modal-title').html('{{ trans('backend/systems.detail') }}');
            var trace = '<code>';
            trace += $(this).closest('tr').find('.stack').html();
            trace += '</code>';
            $('#common-modal .modal-body').html(trace);
            $('#common-modal .modal-dialog').addClass('modal-lg');
            $('#common-modal').modal();
        });
    });
@endsection
