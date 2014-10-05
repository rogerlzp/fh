<div class="row js-trick-container">
	@if($activities->count())
		@foreach($activities as $activity)
			@include('activity.card', [ 'activity' => $activity ])
		@endforeach
	@else
		<div class="col-lg-12">
			<div class="alert alert-danger">
				{{ trans('activity.no_activity_found') }}				
			</div>
		</div>
	@endif
</div>
@if($activities->count())
	<div class="row">
	    <div class="col-md-12 text-center">
	    	@if(isset($appends))
	        	{{ $activities->appends($appends)->links(); }}
	        @else
				{{ $activities->links(); }}
	        @endif
	    </div>
	</div>
@endif

@section('scripts')
	@if(count($activities))
		<script src="{{ asset('js/vendor/masonry.pkgd.min.js') }}"></script>
		<script>
		$(function(){
			$container=$(".js-trick-container");
			$container.masonry({
				gutter:0,
				itemSelector:".trick-card",
				columnWidth:".trick-card"});
			$(".js-goto-trick a").click(function(e){e.stopPropagation()});
			$(".js-goto-trick").click(function(e){e.preventDefault();
			var t="{{ route('activity.show') }}";
			var n=$(this).data("slug");
			window.location=t+"/"+n})})
		</script>
	@endif
@stop
