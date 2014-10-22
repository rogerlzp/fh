@section('title', trans('admin.viewing_users'))



@section('content')
{{ Form::open(['url'=>URL::route('search.stocks'),'method'=>'GET']);}}
	<input type="text" name="q" class="search-box form-control" placeholder="{{ trans('partials.search_placeholder') }}" value="{{{isset($term) ? $term : ''}}}">
	<input style="display:none;" type="submit" value="search">
{{ Form::close()}}

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h2>{{ trans('stock.all') }}</h2>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table">
			   	<thead>
			    	<tr>
						<th>{{ trans('stock.code') }}</th>
						<th>{{ trans('stock.current_price') }}</th>
						<th>{{ trans('stock.change_amount') }}</th>
						<th>{{ trans('stock.change_percent') }}</th>
						<th>{{ trans('stock.volume') }}</th>
						<th>{{ trans('stock.market_value') }}</th>
			    	</tr>
			   	</thead>
			   	<tbody>
				  	@foreach($stocks as $stock)
				    <tr>
				   
							<td><a href="{{url('stock/'.$stock->code)}}" target="_blank"> 
							{{$stock->name}} ({{$stock->code}})</a></td>
							<td>{{$stock->current_price}}</td>
							<td></td>
							<td></td>
							<td></td>
				
				       		 <td>
			        	<div class="btn-group pull-right">
				        <a class="btn btn-primary btn-sm"
				         href="{{url('stock/buy/'.$stock->code) }}">
				        {{ trans('stock.buy') }}</a>
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
			<div class="text-center">{{ $stocks->links(); }}</div>
		</div>
	</div>
</div>
@stop
