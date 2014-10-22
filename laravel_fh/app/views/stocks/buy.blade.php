@section('title', trans('admin.viewing_users')) 

@section('scripts')

<script type="text/javascript">
jQuery(function ($){
	enableSelectBoxes();
	enableOperationSelectBoxes();
});

function enableSelectBoxes(){
    $('div.selectBox').each(function(){
    	$(this).children('span.selected').html($(this).children('div.selectOptions').children('span.selectOption:first').html());
    	$(this).attr('value',$(this).children('div.selectOptions').children('span.selectOption:first').attr('value'));
    	 $('#portfolio').attr('value',$(this).attr('value')); 

    	$(this).children('span.selected,span.selectArrow').click(function(){
    		 $(".testcss").first().css("z-index","-100"); 
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
    	    $(".testcss").first().css("z-index","1"); 
    	   
    	    
    	});
    	
    });
}


function enableOperationSelectBoxes(){
    $('div.operationSelectedBox').each(function(){
    	$(this).children('span.selected').html($(this).children('div.selectOptions').children('span.selectOption:first').html());
    	$(this).attr('value',$(this).children('div.selectOptions').children('span.selectOption:first').attr('value'));
    	 $('#operation').attr('value',$(this).attr('value')); 

    	$(this).children('span.selected,span.selectArrow').click(function(){
    		 $(".testcss").last().css("z-index","-100"); 
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
    	    $(this).closest('div.operationSelectedBox').attr('value',$(this).attr('value'));
    	    $(this).parent().siblings('span.selected').html($(this).html());
    	    $('#operation').attr('value',$(this).attr('value'));    	 
    	    $(".testcss").last().css("z-index","1");    
    	});
    	
    });
}


</script>

@stop 

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-8">
			{{ Form::open(array('class'=>'form-horizontal', 'url'=>
			route('stock.buy')))}}

			<div class="form-group">
				<label for="title" class="col-lg-2 col-md-offset-4  control-label">{{
					trans('portfolio.name') }}</label>

				<div class="form-group" hidden=true>{{Form::text('portfolio', null,
					array('class'=>'form-control','id'=>'portfolio',
					'placeholder'=>trans('board.title_placeholder') ));}}</div>

				<div class="col-lg-4 col-md-offset-14">
					<div class='selectBox'>
						<span class='selected' id="selectedBox"></span> <span
							class='selectArrow'>&#9660</span>
						<div class="selectOptions">
							@foreach ($portfolioList as $key=>$value) <span
								class="selectOption" value="{{$key}}"> {{$value}}</span>
							@endforeach
						</div>
					</div>
				</div>
			</div>

			<div class="form-group testcss">
				<label for="title" class="col-lg-2 col-md-offset-4  control-label">{{
					trans('stock.code') }}</label>
				<div class="col-lg-4 col-md-offset-14 ">{{
					Form::text('code',null,array('class'=>'form-control'))}}</div>
			</div>
			<div class="form-group">
				<label for="url" class="col-lg-2 col-md-offset-4  control-label">{{
					trans('stock.price') }}</label>
				<div class="col-lg-4 col-md-offset-14">{{
					Form::text('buy_price',null,array('class'=>'form-control','rows'=>'4'))}}
				</div>
			</div>
			<div class="form-group">
				<label for="url" class="col-lg-2 col-md-offset-4  control-label">{{
					trans('stock.quantity') }}</label>
				<div class="col-lg-4 col-md-offset-14">{{
					Form::text('buy_quantity',null,array('class'=>'form-control','rows'=>'4'))}}
				</div>
			</div>
			
			<div class="form-group">
			
			<label for="url" class="col-lg-2 col-md-offset-4 control-label">{{
					trans('stock.operation') }}</label>
					
						<div class="form-group" hidden=true>{{Form::text('operation', null,
					array('class'=>'form-control','id'=>'operation',
					'placeholder'=>trans('board.title_placeholder') ));}}</div>

				<div class="col-lg-4 col-md-offset-14">
				<div class='operationSelectedBox' >
					<span class='selected' id="operationSelectedBox"></span> <span
						class='selectArrow'>&#9660</span>
				
					<div class="selectOptions">
						<span class="selectOption" value="0" >{{trans('stock.buy')}}</span> <span
							class="selectOption" value="1"> {{trans('stock.sell')}}</span>
					</div>			
				</div>
				</div>
				
			</div>
			
	
			
			<div class="form-group testcss">
				<div class="col-lg-5 col-md-offset-5 ">{{
					Form::submit(trans('stock.confirm'),array('class'=>'btn btn-lg btn-primary 
					')); }}
			{{
					Form::submit(trans('stock.cancel'),array('class'=>'btn btn-lg btn-primary 
					')); }}</div>
			</div>
			{{ Form::close()}}
		</div>
	</div>

</div>
@stop
