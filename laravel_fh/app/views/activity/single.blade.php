@section('title', $activity->pageTitle)
@section('description', $activity->pageDescription)

@section('scripts')
    <script src="{{ url('js/vendor/highlight.pack.1.js')}}"></script>
    <script type="text/javascript">
    (function($) {
        hljs.tabReplace = '  ';
        hljs.initHighlightingOnLoad();
        $('[data-toggle=tooltip]').tooltip();
    })(jQuery);
    </script>
    @if(Auth::check())
    <script>
    (function(e){e(".js-like-trick").click(
    	    function(t){
        	    t.preventDefault();
        	    var n=e(this).data("liked")=="0";
        	    var r={
                	    _token:"{{ csrf_token() }}"};
        	    e.post('{{ route("activity.like", $activity->slug) }}',
                r,function(t){
                    if(t!="error"){
                        if(!n){
                            e(".js-like-trick .fa").removeClass("text-primary");
                            e(".js-like-trick").data("liked","0");
                            e(".js-like-status").html("Like this?")}
                        else{ 
                            e(".js-like-trick .fa").addClass("text-primary");
                        	e(".js-like-trick").data("liked","1");
                        	e(".js-like-status").html("You like this")
                        }
                        e(".js-like-count").html(t+" likes")
                        }})})})(jQuery)
    </script>
    @endif
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="content-box">	
                	<div > <p>{{trans('activity.title')}}: </p> <p>{{ $activity->title }} </p> </div>
                    
                    <p>{{trans('activity.topic')}}: </p> <p> {{ $activity->topic }} </p>
                    <p>{{{ $activity->yy }}}</p>
                     <p> {{ $activity->note }}</p>
                    <p>{{{ $activity->description }}}</p>
                    <pre><code class="php">{{{ $activity->code }}}</code></pre>
                </div>
            </div>
                <div class="col-lg-3 col-md-4">
                    <div class="content-box">
                        <b>Stats</b>
                        <ul class="list-group trick-stats">
                            <a href="#" class="list-group-item js-like-trick" data-liked="{{ $activity->likedByUser(Auth::user()) ? '1' : '0'}}">

                                <span class="fa fa-heart @if($activity->likedByUser(Auth::user())) text-primary @endif"></span>
                                @if(Auth::check())
                                <span class="js-like-status">
                                    @if($activity->likedByUser(Auth::user()))
                                        You like this
                                    @else
                                        Like this?
                                    @endif
                                </span>
                                <span class="pull-right js-like-count">
                                @endif
                                    {{ $activity->vote_cache }} {{ Str::plural('like', $activity->vote_cache) }}
                                @if(Auth::check())</span>@endif
                            </a>
                            <li class="list-group-item">
                                <span class="fa fa-eye"></span> {{ $activity->view_cache }} views
                            </li>
                        </ul>
                        @if(count($activity->allCategories))
                            <b>Categories</b>
                            <ul class="nav nav-list push-down">
                                @foreach($activity->allCategories as $category)
                                    <li>
                                        <a href="{{ route('activity.browse.category', $category->slug) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if(count($activity->tags))
                            <b>Tags</b>
                            <ul class="nav nav-list push-down">
                                @foreach($activity->tags as $tag)
                                    <li>
                                        <a href="{{ route('activity.browse.tag', $tag->slug) }}">
                                            {{ $tag->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="clearfix">
                            @if($prev)
                                <a  href="{{ route('activity.show', $prev->slug) }}"
                                    title="{{ $prev->title }}" data-toggle="tooltip"
                                    class="btn btn-sm btn-primary">
                                        &laquo; Previous Activity
                                </a>
                            @endif

                            @if($next)
                                <a  href="{{ route('activity.show', $next->slug) }}"
                                    title="{{ $next->title }}" data-toggle="tooltip"
                                    class="btn btn-sm btn-primary pull-right">
                                        Next Activity &raquo;
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>



        {{--<div class="row">
            <div class="col-lg-12">
                <h2 class="title-between">Related activity</h2>
            </div>
        </div>
        <div class="row">
            @for($i = 0; $i < 3; $i++)
                @include('activity.card', [ 'test' => $i ])
            @endfor
        </div>--}}

    </div>
@stop
