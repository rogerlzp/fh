@section('title', trans('user.profile')) 

@section('styles')
<link rel="stylesheet"
	href="{{ URL::asset('css/user.css') }}">
@stop 

@section('content')
<div class="container">
	<div class="uc-full-box">
		<div class="span16 col-md-10">
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
						<ul>
						<li>评论</li>
						<li>表现</li>
						<li>介绍</li>
						</ul>
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
										@foreach($portfolio->portfolioItems as $portfolioItem)
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
									</tr>
								</thead>
								<tbody id="sortable">
									@foreach($portfolio->accounts as $account)
									<tr rel="{{ $account->id }}">
										<td><a href="{{url('account/'.$account->id)}}">{{
												$account->type }}</a></td>
										<td>{{ $account->description}}<br>
										</td>
										<td>{{ $account->original_balance}}</td>
										<td>{{ $account->balance}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

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

