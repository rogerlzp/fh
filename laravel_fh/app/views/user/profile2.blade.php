@section('title', trans('user.profile'))

@section('content')
<div class="container">
<p> hello world</p>
		<div class="row push-down">
		<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
			<h1 class="page-title">{{ trans('user.my_tricks') }}</h1>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-right">
			<a href="{{ url('user/tricks/new')}}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> {{ trans('user.create_new') }}</a>
		</div>
	</div>

	@include('board.grid', [ 'boards' => $boards ])
	
@stop



