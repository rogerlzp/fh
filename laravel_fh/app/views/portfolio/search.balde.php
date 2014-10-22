@section('title', trans('admin.viewing_portfolios')) 

@section('content') 

{{Form::open(['url'=>URL::route('search.portfolios'),'method'=>'GET']);}}
<input type="text" name="q"
	class="search-box form-control"
	placeholder="{{ trans('partials.search_placeholder') }}"
	value="{{{isset($term) ? $term : ''}}}">
<input
	style="display: none;" type="submit" value="search">
{{ Form::close()}}

<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1>{{ trans('portfolio.search_result') }} ({{ $portfolios->getTotal() }})</h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table">
				<thead>
					<tr>
						<th>{{ trans('portfolio.name') }}</th>
						<th>{{ trans('portfolio.username') }}</th>
						<th>{{ trans('portfolio.return_rate') }}</th>
						<th>{{ trans('stock.change_percent') }}</th>
						<th>{{ trans('stock.volume') }}</th>
						<th>{{ trans('stock.market_value') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($portfolios as $portfolio)
					<tr>
					<td> 
						<a href="{{url('portfolio'.$portfolio->id)}}" target="_blank">

							{{$portfolio->name}} </a></td>
							<td>{{$portfolio->return_rate}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>

							<td><span> <a data-toggle="modal" href="#add_stock"
									class="btn btn-primary btn-lg">{{ trans('portfolio.watch') }}</a>
							</span>
						</td>
						</a>
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

	<!-- Modal -->
	<div class="modal fade" id="add_stock" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">&times;</button>
					<h4 class="modal-title">{{ trans('admin.adding_new_category') }}</h4>
				</div>
				<div class="modal-body">
					@if($errors->all())
					<div class="bs-callout bs-callout-danger">
						<h4>{{ trans('admin.please_fix_errors') }}</h4>
						{{ HTML::ul($errors->all())}}
					</div>
					@endif {{ Form::open(array('class'=>'form-horizontal', 'url'=>
					route('stock.add')))}}
					<div class="form-group">
						<label for="title" class="col-lg-2 control-label">{{
							trans('stock.code') }}</label>
						<div class="col-lg-10">{{
							Form::text('code',null,array('class'=>'form-control'))}}</div>
					</div>
					<div class="form-group">
						<label for="url" class="col-lg-2 control-label">{{
							trans('admin.description') }}</label>
						<div class="col-lg-10">{{
							Form::textarea('description',null,array('class'=>'form-control','rows'=>'4'))}}
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">{{
							Form::submit('Create',array('class'=>'btn btn-lg btn-primary
							btn-block')); }}</div>
					</div>
					{{ Form::close()}}
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


</div>
@stop 

@section('scripts')
<script
	type="text/javascript"
	src="{{url('js/vendor/jquery-ui-1.10.3.custom.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		@if($errors->all())
		$('#add_stock').modal('show');
		@endif
	});

</script>

@stop

