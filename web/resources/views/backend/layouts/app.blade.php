<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{!! $title or '' !!} | {{ config('app.name') }}</title>
    {!! Html::style('css/bootstrap.min.css') !!}
    {!! Html::style('css/font-awesome.min.css') !!}
    {!! Html::style('backend/css/animate.min.css') !!}
    {!! Html::style('backend/css/bootstrap-switch.min.css') !!}
    {!! Html::style('backend/css/checkbox3.min.css') !!}
    {!! Html::style('backend/css/select2.min.css') !!}
    {!! Html::style('backend/datatables/dataTables.bootstrap.css') !!}
    {!! Html::style('backend/datatables/extensions/Responsive/css/dataTables.responsive.css') !!}
    {!! Html::style('backend/file-input/css/fileinput.min.css') !!}
    {!! Html::style('backend/css/multiselect.css') !!}
    {!! Html::style('backend/iCheck/all.css') !!}
    {!! Html::style('backend/iCheck/flat/blue.css') !!}
    {!! Html::style('backend/css/flat-style.css') !!}
    {!! Html::style('backend/css/flat-green.css') !!}
    {!! Html::style('backend/css/style.css') !!}
    @yield('css-file')
    @yield('css')
</head>
<body class="flat-green">
    <div class="overlay">
        {!! Html::image('/images/loading.gif') !!}
    </div>
    <div class="app-container">
        <div class="row content-container">
            @include('backend.layouts.header')
            @include('backend.layouts.sidebar')
            <div class="container-fluid">
                <div class="side-body">
                    <div class="page-title">
                        <span class="title">{!! $pageTitle or '' !!}</span>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
        @include('backend.layouts.footer')
    </div>
    @include('backend.partial.alert')
    @include('backend.partial.confirm')
    @include('backend.partial.modal')

    {!! Html::script('js/jquery-2.2.4.min.js') !!}
    {!! Html::script('js/bootstrap.min.js') !!}
    {!! Html::script('backend/js/bootstrap-switch.min.js') !!}
    {!! Html::script('backend/js/jquery.matchHeight-min.js') !!}
    {!! Html::script('backend/js/select2.full.min.js') !!}
    {!! Html::script('backend/datatables/jquery.dataTables.min.js') !!}
    {!! Html::script('backend/dataTables/dataTables.bootstrap.min.js') !!}
    {!! Html::script('backend/datatables/extensions/Responsive/js/dataTables.responsive.min.js') !!}
    {!! Html::script('backend/iCheck/icheck.min.js') !!}
    {!! Html::script('backend/file-input/js/fileinput.min.js') !!}
    {!! Html::script('backend/js/multiselect.js') !!}
    {!! Html::script('backend/js/ace.js') !!}
    {!! Html::script('backend/js/mode-html.js') !!}
    {!! Html::script('backend/js/theme-github.js') !!}
    {!! Html::script('backend/js/app.js') !!}
    {!! Html::script('backend/js/main.js') !!}

    @yield('js-file')

    <script type="text/javascript">
        $(document).ready(function(){
            $('input[type="checkbox"].icheckbox-blue').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
            $('input[type="checkbox"].icheckbox-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            });

            $('.toggle-checkbox').bootstrapSwitch({
                size: "small",
                onText: '{{ trans('system.enable') }}',
                offText: '{{ trans('system.disable') }}'
            });

            $('[data-toggle="tooltip"]').tooltip()
        });
        @yield('js')
    </script>
</body>
</html>
