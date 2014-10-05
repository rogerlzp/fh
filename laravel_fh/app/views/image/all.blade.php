

@section('title', trans('user.profile'))

@section('content')
<div class="container">
	@if(Session::has('first_use'))
	  <div class="alert alert-success alert-dismissable text-center">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h4>{{ trans('user.welcome') }}</h4>
		<p>{{ trans('user.welcome_subtitle') }}</p>
	  </div>
	@endif

	@if(Session::has('success'))
	    <div class="alert alert-success alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	         <h5>{{ Session::get('success') }}</h5>
	    </div>
	@endif

	@include('image.all_image', [ 'images' => $images ])
</div>
@stop



