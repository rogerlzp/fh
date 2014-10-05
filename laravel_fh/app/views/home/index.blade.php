@section('title', trans('home.welcome'))

@section('content')
	<div class="container">
		<div class="row push-down">
			<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
				<img src="{{ URL::asset('img/home.jpg') }}" class="item">
			</div>
		
		
			<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
				<h1 class="page-title">{{ trans('home.latest_activity') }}</h1>
			</div>
		</div>
		@include('activity.grid', ['activities' => $activities])
	</div>
@stop
