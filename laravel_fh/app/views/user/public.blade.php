@section('title', $user->fullName)

@section('scripts')
<script>
$(document).ready(function(){
	

});

function toggleFollow(){		
	if($('#follow').text().trim() === "follow") {
	$.ajax({ 
        url: "{{URL::route('user.follow')}}",
        dataType: 'json', 
        data: {'follow_id': "{{$user->id}}", _token: "{{ csrf_token() }}"} ,
        type: "POST", 
        success: function(output){ 
            $('#follow').text("unfollow");
        }
	});
	} else {
		$.ajax({ 
	        url: "{{URL::route('user.unfollow')}}",
	        dataType: 'json', 
	        data: {'follow_id': "{{$user->id}}", _token: "{{ csrf_token() }}"} ,
	        type: "POST", 
	        success: function(output){ 
	        	 $('#follow').text("follow");
	        }
		});

	}
}

</script>

@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="content-box">
                <div class="trick-user">
                    <div class="trick-user-image">
                        <img src="{{ $user->photocss }}" class="user-avatar">
                    </div>
                    <div class="trick-user-data">
                        <h1 class="page-title">
                            {{ $user->fullName }}
                        </h1>
                        <div class="text-muted">
                            <b>{{ trans('user.joined') }}</b> {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
               
                </div>
              <div class="text-muted">
                      <b>followers</b>
                </div>
                  <div class="text-muted">
                            <b>followings:</b>
                  </div>
                  
                  @if(Auth::user()->follows) 
                  <p>follows</p>
                  @else
                  <p>not follow</p>
                  @endif
                  
                  <div class="btn btn-primary" onclick="toggleFollow()">
                            <p id="follow">follow</b>
                  </div>
                        
                <table>
                    <tr>
                        <th>{{ trans('user.total_tricks') }}</th>
                        <td>{{ count($boards) }}</td>
                    </tr>
                    <tr>
                        <th width="140">{{ trans('user.last_trick') }}</th>
                       
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="row push-down">
        <div class="col-lg-12">
            <h1 class="page-title">{{ trans('user.submitted_tricks') }}</h1>
        </div>
    </div>

    @include('board.grid', [ 'boards' => $boards ])
</div>


@stop
