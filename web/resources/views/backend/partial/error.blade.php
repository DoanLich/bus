@if (count($errors) > 0)
    <!-- Form Error List -->
    <div class="alert alert-danger fresh-color fadeOut">
    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif