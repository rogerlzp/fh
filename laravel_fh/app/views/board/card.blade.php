<div href="#" class="trick-card col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<div class="trick-card-inner js-goto-trick" data-slug="{{ $board->board_name }}">
		<div class="trick-card-stats trick-card-by"> <b><a href="{{route('board.show', $board->id)}}">
		{{ $board->board_name }}</b></div>
		<div class="trick-card-stats trick-card-by">by <b><a href="{{ route('user.profile',
		 $board->user->username) }}">{{ $board->user->username }}</a></b></div>
		<div class="trick-card-stats clearfix">
		</div>
	</div>
</div>


