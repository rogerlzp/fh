@section('title', trans('user.profile'))

@section('scripts')
<script type="text/javascript">
function addComment(){
	$.ajax({ 
        url: "{{URL::route('user.comment')}}",
        dataType: 'json', 
        data: {'image_id': "{{$image->id}}", content:$('#comment_text').val(), _token: "{{ csrf_token() }}"}  ,
        type: "POST", 
        success: function(output){ 
        	
            var html="<div id=\"comment-item\"><p>" + output.content + "</p><p>"
            			+ output.updated_at + "</p>";
            $('#comments').append(html);
        } 
    }); 
}

$(document).ready(function(){
	
	
});

</script>
@stop


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



	<div class="row js-trick-container">
	<div id="image_container">
		<div><img src="{{ URL::asset('img/temp/'.$image->image_path) }}"></div>
		<div><p>描述: {{ $image->description }}</div>
	</div>
	</div>
	
	<div class="comment-load-image"  id="comments">
		@foreach ($comments as $comment)
		<div id="comment-item">
		<p> {{$comment->content}}</p>
		<p> {{$comment->auther_id}}</p>
		<p> {{$comment->updated_at}} </p>
		</div>
		@endforeach
		
	</div>
	
	<div class="comment-form-image">
		<input type="text" id="comment_text" placeholder="add some comment...">
		<input type="button" value="comment" onclick="addComment()">	
		
	</div>
	
</div>
@stop



