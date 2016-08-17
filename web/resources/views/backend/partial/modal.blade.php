<div class="modal fade" tabindex="-1" role="dialog" id="{{ isset($id) ? $id : 'common-modal' }}">
	<div class="modal-dialog"{{ isset($width) ? ' style="width: '.$width.'"' : '' }}>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">{{ isset($header) ? $header : trans('backend/systems.message') }}</h4>
			</div>
			<div class="modal-body">
				{{ isset($body) ? $body : '' }}
			</div>
			<div class="modal-footer">
				<button type="button" class="close-modal btn btn-primary" data-dismiss="modal">{{ trans('backend/systems.close') }}</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->