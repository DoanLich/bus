@if(Session::has('success'))
	<div class="alert alert-success fresh-color fadeOut on-page">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span>{!! Session::get('success') !!}</span>
	</div>
@endif
@if(Session::has('info'))
	<div class="alert alert-info fresh-color fadeOut on-page">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span>{!! Session::get('info') !!}</span>
	</div>
@endif
@if(Session::has('error'))
	<div class="alert alert-danger fresh-color fadeOut on-page">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span>{!! Session::get('error') !!}</span>
	</div>
@endif
@if(Session::has('warning'))
	<div class="alert alert-warning fresh-color fadeOut on-page">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span>{!! Session::get('warning') !!}</span>
	</div>
@endif
@if(Session::has('message'))
	<div class="alert alert-info fresh-color fadeOut on-page">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span>{!! Session::get('message') !!}</span>
	</div>
@endif
@if(Session::has('status'))
	<div class="alert alert-info fresh-color fadeOut on-page">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span>{!! Session::get('status') !!}</span>
	</div>
@endif