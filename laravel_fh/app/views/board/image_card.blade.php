<div href="#" class="trick-card col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<div class="trick-card-inner js-goto-trick" data-slug="{{ $image->image_id }}">
		<div class="trick-card-stats trick-card-by"> <b>	<a href="{{$image->id}}"> <img class="item"
					src="{{ URL::asset('img/temp/'.$image->image_path) }}">
				</a></b>
		
		</div>
	
		<div class="trick-card-stats trick-card-by">by <b><a href="{{ route('user.profile',
		 $image->user->username) }}">{{ $image->user->username }}</a></b></div>
		<div class="trick-card-stats clearfix">
		</div>
	</div>
</div>


