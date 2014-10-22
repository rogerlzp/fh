@section('title', trans('user.profile')) 

@section('styles')
<link rel="stylesheet"
	href="{{ URL::asset('css/user.css') }}">

@stop 



@section('content')
<div class="container">
	<div class="uc-full-box">

		<div class="span4 col-md-3">
			<div class="uc-nav-box">
				<div class="box-hd">
					<h3 class="title">{{trans('user.center')}}</h3>
				</div>
				<div class="box-bd">
					<ul class="uc-nav-list">
						<li class="current"><a href="{{ url('user/profile')}}">{{trans('user.info')}}</a>

						</li>
						<li><a href="#">我的订单</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="uc-nav-box">
				<div class="box-hd">
					<h3 class="title">{{trans('portfolio.portfolio')}}</h3>
				</div>
				<div class="box-bd">
					<ul class="uc-nav-list">
						<li id="myinvest"><a href="{{ route('portfolio.profile_showmy')}}"}}">{{trans('portfolio.myportfolio')}}</a>
						</li>
						<li><a href="{{url('user/profile')}}">{{trans('portfolio.buy_portfolio')}}</a>
						</li>
						<li><a href="#">{{trans('portfolio.follow_portfolio')}}</a></li>
					</ul>
				</div>
			</div>
			<div class="uc-nav-box">
				<div class="box-hd">
					<h3 class="title">{{trans('user.account_manage')}}</h3>
				</div>
				<div class="box-bd">
					<ul class="uc-nav-list">
						<li><a href="#" target="_blank">{{trans('usr.modify_password') }}</a>
						</li>
						<li><a href="#" target="_blank">VIP认证</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- .span4 END -->


		<div class="span16 col-md-9">
			<div class="xm-box ">
				<div class="">
					<div class="box-bd" id="myportfolio-info">
						<div class="uc-info">
							<div class="xm-line-box uc-home-box">
						<div class="box-hd">
						
							<h3 class="title">{{$portfolio->name}}</h3>
						</div>
							<div class="uc-info-detail">
								<label for="title" class="col-lg-2 control-label">{{
									trans('portfolio.strategy') }}: </label>
								<div class="info-notice">{{$portfolio->description}}</div>
								
							</div>
						</div>	
						</div>
						
							<div class="xm-line-box uc-home-box">
							<div>
								<table class="table">
									<thead>
										<tr>
											<th>{{ trans('stock.code') }}</th>
											<th>{{ trans('portfolio.return_rate') }}</th>
											<th>{{ trans('portfolio.value') }}</th>

											<th>{{ trans('stock.current_price') }}</th>
											<th>{{ trans('portfolio.quantity') }}</th>
											<th>{{ trans('portfolio.percentage') }}</th>

										</tr>
									</thead>
									<tbody id="sortable">
									 @if($portfolioItems) 
										@foreach($portfolioItems as $portfolioItem)
										<tr rel="{{ $portfolioItem->id }}">
											<td><a href="{{url('stock/'.$portfolioItem->stock_code) }}">
													{{$portfolioItem->stock_code}}</a></td>
							
											<td>{{number_format((($portfolioItem->stock->current_price-$portfolioItem->buy_price)/$portfolioItem->buy_price)*100, 2)}}%
											</td>
											<td>{{$portfolioItem->stock->current_price *
												$portfolioItem->buy_quantity }}</td>
											<td>{{ $portfolioItem->stock->current_price}}<br>
											</td>
											<td>{{ $portfolioItem->buy_quantity}}</td>
											<td></td>
										</tr>
										@endforeach
										@endif
									</tbody>
								</table>



							</div>
							
							
						</div>
						
						
						
						
					</div>
					<div class="xm-line-box uc-home-box">
								<label for="title" class="col-lg-2 control-label">{{
									trans('portfolio.stock_gain') }}: </label>
								<div class="info-notice">{{$portfolio->description}}</div>
								
							</div>
							
					
					<!-- .uc-info-box END -->

					<!-- .uc-home-box END -->

					<div class="xm-line-box uc-home-box">
						<div class="box-hd">
							<h3 class="title">{{trans('portfolio.account')}}</h3>
						</div>

						<div class="col-lg-12">
							<table class="table">
								<thead>
									<tr>
										<th>{{ trans('account.type') }}</th>
										<th>{{ trans('account.description') }}</th>
										<th>{{ trans('account.original_balance') }}</th>
										<th>{{ trans('account.balance') }}</th>
										<th class="col-lg-3 text-right">{{ trans('admin.actions') }}</th>
									</tr>
								</thead>
								<tbody id="sortable">
								 @if($accounts) 
									@foreach($accounts as $account)
									<tr rel="{{ $account->id }}">
										<td><a href="{{url('account/'.$account->id)}}">{{
												$account->type }}</a></td>
										<td>{{ $account->description}}<br>
										</td>
										<td>{{ $account->original_balance}}</td>
										<td>{{ $account->balance}}</td>
										<td>
											<div class="btn-group pull-right">
												<a class="btn btn-primary btn-sm"
													href="{{url('account/'.$account->id)}}">{{
													trans('admin.edit') }}</a> <a
													class="delete_toggler btn btn-danger btn-sm"
													rel="{{$account->id}}">{{ trans('admin.delete') }}</a>
											</div>
										</td>
									</tr>
									@endforeach
									@endif
								</tbody>
							</table>
						</div>

						<div class="box-bd">
							<div class="uc-tip-section">


								<span> <a data-toggle="modal" href="#add_account"
									class="btn btn-primary btn-lg">{{
										trans('portfolio.add_new_account') }}</a>
								</span>

							</div>
						</div>
					</div>

					<div class="row"></div>

				</div>
			</div>


		</div>

	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="add_account"
	tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title">{{ trans('portfolio.add_new_account') }}</h4>
			</div>
			<div class="modal-body">
				@if($errors->all())
				<div class="bs-callout bs-callout-danger">
					<h4>{{ trans('admin.please_fix_errors') }}</h4>
					{{ HTML::ul($errors->all())}}
				</div>
				@endif {{ Form::open(array('class'=>'form-horizontal',
				'url'=>route('account.create') ))}}
				<div class="form-group">
					<label for="title" class="col-lg-2 control-label">{{
						trans('account.original_balance') }}</label>
					<div class="col-lg-10">{{
						Form::text('original_balance',null,array('class'=>'form-control'))}}
					</div>
				</div>
				<div class="form-group">
					<label for="url" class="col-lg-2 control-label">{{
						trans('account.description') }}</label>
					<div class="col-lg-10">{{
						Form::textarea('description',null,array('class'=>'form-control','rows'=>'2'))}}
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-10">
						<input type="hidden" id="portfolioId" name="portfolioId"
							value="{{$portfolio->id}}">
					</div>
				</div>

				<div class="form-group" hidden=true>{{Form::text('type', null,
					array('class'=>'form-control','id'=>'type',
					'placeholder'=>trans('board.title_placeholder') ));}}</div>


				<div class='selectBox'>
					<span class='selected' id="selectedBox"></span> <span
						class='selectArrow'>&#9660</span>
					<div class="selectOptions">
						<span class="selectOption" value="0"> USD</span> <span
							class="selectOption" value="1"> RMB</span>
					</div>
				</div>
			</div>


			<div class="form-group">
				<div class="col-lg-10 col-lg-offset-2">{{
					Form::submit(trans('portfolio.create'),array('class'=>'btn btn-lg
					btn-primary ')); }}</div>
			</div>
			{{ Form::close()}}
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@stop 

@section('scripts')
<script
	type="text/javascript"
	src="{{url('js/vendor/jquery-ui-1.10.3.custom.min.js')}}"></script>

<script type="text/javascript">
function getMyPorfile() {
	$.ajax({ 
        url: "{{URL::route('portfolio.profile_showmy')}}",
        dataType: 'json', 
        type: "GET", 
        success: function(output){ 
            alert(output);     
            $('#user-info').css('display','none');;
        } 
    }); 
}



//jQuery(function ($){
	


		
//});

$(document).ready(function(){
//	$('#add_account').modal('show');
	enableSelectBoxes();
	$('#myinvest').click(function(){
		getMyPorfile() ;
		});

	getRate();
	
});

function getRate() {
	$
	
}



function enableSelectBoxes(){
    $('div.selectBox').each(function(){
    	$(this).children('span.selected').html($(this).children('div.selectOptions').children('span.selectOption:first').html());
    	$(this).attr('value',$(this).children('div.selectOptions').children('span.selectOption:first').attr('value'));
    	 $('#portfolio').attr('value',$(this).attr('value')); 

    	$(this).children('span.selected,span.selectArrow').click(function(){
    	    if($(this).parent().children('div.selectOptions').css('display') == 'none'){
    	        $(this).parent().children('div.selectOptions').css('display','block');
    	    }
    	    else
    	    {
    	        $(this).parent().children('div.selectOptions').css('display','none');
    	    }
    	});
    	
    	$(this).find('span.selectOption').click(function(){
    	    $(this).parent().css('display','none');
    	    $(this).closest('div.selectBox').attr('value',$(this).attr('value'));
    	    $(this).parent().siblings('span.selected').html($(this).html());
    	    $('#portfolio').attr('value',$(this).attr('value'));    	    
    	});
    	
    });

}

</script>
@stop

