@section('css-file')
    {!! Html::style('backend/css/datatable.css') !!}
@stop
<table class="table table-striped table-hover dt-responsive" id="{{ !empty($tableId) ? $tableId : 'datatable-list' }}" width="100%">
    <thead>
        <tr class="column-title">
            @foreach($columns as $column)
                <th></th>
            @endforeach
        </tr>
        @if(!empty($searchColumns))
            <tr id="filter-row">
                @foreach($columns as $key => $column)
                    <th id="{{ $key }}"></th>
                @endforeach
            </tr>
        @endif
    </thead>
</table>
@section('js-file')
    {!! Html::script('backend/js/datatable.js') !!}
@stop
@section('list-js')
    var columns = {!! json_encode($columns) !!};
    var searchColumns = {!! !empty($searchColumns) ? json_encode($searchColumns) : '{}' !!};
    var defaultOrder = {!! isset($defaultOrder) && $defaultOrder != null ? $defaultOrder : '[]' !!};
    var datatableUrl = '{!! $datatableUrl !!}';
    var tableId = '{{ !empty($tableId) ? $tableId : 'datatable-list' }}';
    $(document).ready(function() {
        $('#' + tableId)
        .DataTable({
            processing: true,
            serverSide: true,
            bSortCellsTop: true,
            ajax: datatableUrl,
            columns: columns,
            fnDrawCallback: function(){
                $('input[type="checkbox"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
                disableDeleteSelectedButton();

                $('#datatableSelectAll').iCheck('uncheck');
                var isClick = false;
                $('#datatableSelectAll').on('ifClicked ifChecked ifUnchecked', function(event){
                    var type = event.type.replace('if', '').toLowerCase();
                    type = type.replace('ed', '');
                    if(type == 'click') {
                        isClick = true;
                    }
                    if(type == 'check' && isClick) {
                        $('input[name="datatableSelect"]').iCheck('check');
                        enableDeleteSelectedButton();
                        isClick = false;
                    }
                    if(type == 'uncheck' &&  isClick) {
                        $('input[name="datatableSelect"]').iCheck('uncheck');
                        disableDeleteSelectedButton();
                        isClick = false;
                    }
                });

                $('input[name="datatableSelect"].minimal-red').on('ifChecked ifUnchecked', function(event){
                    var type = event.type.replace('if', '').toLowerCase();
                    if(type == 'unchecked') {
                        $('#datatableSelectAll').iCheck('uncheck');

                        if(!checkHasSelected('datatableSelect')) {
                            disableDeleteSelectedButton();
                        }
                    } else {
                        if(checkSelectedAll('datatableSelect')) {
                            $('#datatableSelectAll').iCheck('check');
                        }

                        enableDeleteSelectedButton();
                    }
                });
            },
            "aaSorting": defaultOrder,
            "oLanguage": {
                "oPaginate": {
                    "sNext": "{{ trans('pagination.next') }}",
                    "sPrevious": "{{ trans('pagination.previous') }}"
                },
                "sInfo": "{{ trans('backend/datatables.sInfo') }}",
                sLengthMenu: "{{ trans('backend/datatables.sLengthMenu') }}",
                sSearch: "{{ trans('backend/datatables.sSearch') }}",
                sProcessing: '<img src="{{ url('images/loading.gif') }}">',
                sInfoEmpty: "{{ trans('backend/datatables.sInfoEmpty') }}",
                sEmptyTable: "{{ trans('backend/datatables.sEmptyTable') }}",
            },
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = searchColumns[column.index()];
                    $(input).appendTo($('#filter-row #'+column.index()).empty())
                    .on('change', function () {
                        column.search($(this).val()).draw();
                    });
                });
            }
        });
    });
@endsection