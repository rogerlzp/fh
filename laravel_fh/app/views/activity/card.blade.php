<div href="#" class="trick-card col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<div class="trick-card-inner js-goto-trick" data-slug="{{ $activity->slug }}">
		<a class="trick-card-title" href="{{ route('activity.show', [ $activity->slug ]) }}">
			{{{ $activity->title }}}
		</a>
		<div class="trick-card-stats trick-card-by">by <b>
		<a href="{{ route('user.profile', $activity->user->username) }}">
		{{ $activity->user->username }}</a></b></div>
		<div class="trick-card-stats clearfix">
			<div class="trick-card-timeago">{{ trans('tricks.submitted', 
			array('timeago' => $activity->timeago, 'categories' => $activity->categories)) }}</div>
			<div class="trick-card-stat-block"><span class="fa fa-eye"></span> {{$activity->view_cache}}</div>
			<div class="trick-card-stat-block text-center"><span class="fa fa-comment"></span> 
			<a href="{{ url('activity/'.$activity->slug.'#disqus_thread') }}" 
			data-disqus-identifier="{{$activity->id}}" style="color: #777;">0</a></div>
			<div class="trick-card-stat-block text-right"><span class="fa fa-heart"></span>
			 {{$activity->vote_cache}}</div>
		</div>
		<div class="trick-card-tags clearfix">
			@foreach($activity->tags as $tag)
			    <a href="{{url('tags/'.$tag->slug)}}" class="tag" title="{{$tag->name}}">{{$tag->name}}</a>
			@endforeach
		</div>
	</div>
</div>

