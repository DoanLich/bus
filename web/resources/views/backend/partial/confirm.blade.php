<div class="modal fade" tabindex="-1" role="dialog" id="{{ isset($id) ? $id : 'confirm-modal' }}">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ isset($header) ? $header : trans('backend/systems.message') }}</h4>
            </div>
            {!! Form::open(['method' => 'POST', 'onsubmit' => 'return executeAjaxAction(this)']) !!}
            <div class="modal-body">
                {{ isset($body) ? $body : trans('backend/systems.confirm_message') }}
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <button type="button" class="close-modal btn btn-default" data-dismiss="modal">{{ trans('backend/systems.no') }}</button>
                    <button type="submit" class="close-modal btn btn-primary">{{ trans('backend/systems.yes') }}</button>
                </div>
                <br>
                <div id="confirm-warning" class="text-left alert alert-danger fresh-color" style="display: none;">
                    <span class="message"></span>
                </div>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->