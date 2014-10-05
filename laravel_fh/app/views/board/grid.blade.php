<div class="row js-trick-container">
	@if($boards->count())
		@foreach($boards as $board)
			@include('board.card', [ 'board' => $board ])
		@endforeach
	@else
		<div class="col-lg-12">
			<div class="alert alert-danger">
				{{ trans('tricks.no_tricks_found') }}				
			</div>
		</div>
	@endif
</div>
@if($boards->count())
	<div class="row">
	    <div class="col-md-12 text-center">
	    	@if(isset($appends))
	        	{{ $boards->appends($appends)->links(); }}
	        @else
				{{ $boards->links(); }}
	        @endif
	    </div>
	</div>
@endif

@section('scripts')
	@if(count($boards))
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
			var t="{{ route('tricks.show') }}";
			var n=$(this).data("slug");
			window.location=t+"/"+n})})
		</script>
	@endif
@stop
