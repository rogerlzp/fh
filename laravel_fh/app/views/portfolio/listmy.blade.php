@section('title', trans('admin.viewing_users')) 


@section('content')


<div class="container">

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
					</tr>
				</thead>

				<tr>
					<td><a href="{{url('portfolio/'.$portfolio->name)}}" target="_blank">
							 </a></td>
					<td></td>
					@foreach($portfolioItems as $portfolioItem)
					<td>{{ $portfolioItem->stock_code}}</td>
						<td>{{ $portfolioItem->buy_price}}</td>
						<td>{{ $portfolioItem->buy_quantity}}</td>
					@endforeach
				</tr>

				</tbody>
			</table>
		</div>
	</div>

</div>
@stop
