@section('title', trans('admin.viewing_users'))



@section('content')
{{ Form::open(['url'=>URL::route('search.users'),'method'=>'GET']);}}
	<input type="text" name="q" class="search-box form-control" placeholder="{{ trans('partials.search_placeholder') }}" value="{{{isset($term) ? $term : ''}}}">
	<input style="display:none;" type="submit" value="search">
{{ Form::close()}}

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1>{{ trans('admin.showing_all_users') }} ({{ $users->getTotal() }})</h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table">
			   	<thead>
			    	<tr>
				     	<th>{{ trans('admin.avatar') }}</th>
						<th>{{ trans('admin.username') }}</th>
						<th>{{ trans('admin.email') }}</th>
						<th>{{ trans('admin.phone') }}</th>
						<th>{{ trans('admin.name') }}</th>
						<th>{{ trans('admin.company') }}</th>
						<th>{{ trans('admin.department') }}</th>
						<th>{{ trans('admin.job') }}</th>
						<th>{{ trans('admin.date_registered') }}</th>
			    	</tr>
			   	</thead>
			   	<tbody>
				  	@foreach($users as $user)
				    <tr>
				   
				    	<td> <a href="{{url('admin/users/'.$user->id)}}" target="_blank">
				    	<img src="{{ $user->photocss }}" class="img-rounded" style="width:40px; height:40px;">
				    	</a></td>
				        <td> <a href="{{url('admin/users/'.$user->id)}}" target="_blank">{{$user->username}}</a></td>
				       	<td>{{$user->email}}</td>
				       	<td> {{$user->mobile}}</td>
				       	@if($user->profile)
				       	<td>{{$user->profile->name}}</td>
				       	  	<td>{{$user->profile->company}}</td>
				       	  	<td>{{$user->profile->department}}</td>
				       	  	<td>{{$user->profile->title}}</td>
				   		@endif

				       	<td>{{$user->created_at}}</td>
			
				     </tr>
				    @endforeach
			    </tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="text-center">{{ $users->links(); }}</div>
		</div>
	</div>
</div>
@stop
