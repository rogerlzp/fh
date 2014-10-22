@section('title', trans('admin.viewing_users')) @section('content') {{
Form::open(['url'=>URL::route('search.portfolios'),'method'=>'GET']);}}
<input
	type="text" name="q" class="search-box form-control"
	placeholder="{{ trans('portfolio.search_placeholder') }}"
	value="{{{isset($term) ? $term : ''}}}">
<input
	style="display: none;" type="submit" value="search">
{{ Form::close()}}

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<table class="table">
				<thead>
					<tr>
						<th>{{ trans('portfolio.name') }}</th>
						<th>{{ trans('portfolio.username') }}</th>
						<th>{{ trans('portfolio.history_value') }}</th>
						<th>{{ trans('portfolio.duration_time') }}</th>
						<th>{{ trans('portfolio.rating') }}</th>
						<th>{{ trans('stock.market_value') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($portfolios as $portfolio)
					<tr>
					
						<td><a href="{{url('portfolio/'.$portfolio->id)}}" target="_blank">
								{{$portfolio->name}} </a>
								</td>
							
						<td><a href="{{url('user/'.$portfolio->user->username)}}" target="_blank">
								{{$portfolio->user->username}} </a>
								</td>			
							
						<td>{{$portfolio->return_rate}}</td>
						<td></td>
						<td>
							<div class="btn-group pull-right">
								<div class="btn btn-primary btn-sm" onclick="addWatch()"
								> {{
									trans('portfolio.watch') }}
							</div>
						</td>

					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="text-center">{{ $portfolios->links(); }}</div>
		</div>
	</div>
</div>
@stop
