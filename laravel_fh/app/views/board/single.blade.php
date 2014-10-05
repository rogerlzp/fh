
@section('content')

<div class="trick-card-stats trick-card-by"> <b><a href="{{route('board.show', $board->id)}}">
		{{ $board->board_name }}</b></div>

		@include('board.image_grid', [ 'images' => $board->images ])
		
		
@stop
