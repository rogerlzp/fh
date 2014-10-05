
@section('scripts')
$(document).ready(function{

$.ajax({ 
        url: "{{URL::route('user.board2')}}",
        dataType: 'json', 
        data: {user_id:1} ,
        type: "POST", 
        success: function(output){ 
            alert(output);
        } 
    }); 

});

function addProduct() {
alert("addProduct");
$.ajax({ 
        url: "{{URL::route('admin.product.create')}}",
        dataType: 'json', 
        data: {'name':$("input[name='name']").val(), 'short_description':$("input[name='short_description']").val(),
        'sku':$("input[name='sku']").val(),'stock':$("input[name='stock']").val(), _token: "{{ csrf_token() }}"} ,
        type: "POST", 
        success: function(output){ 
            alert(output);
        } 
    }); 
});

}

@stop

@section('content')
<div class="”container”">
	<div class="row">
	<div class="col-md-1" ></div>
		<div class="col-md-3 span4" >
			<ul class="nav nav-list">
				<li class="nav-header">New Product</li>
				<li class="active"><a href="#">Basic Information</a></li>
				<li><a href="#">add image</a></li>
				<li><a href="#">add category</a></li>
				<li><a href="#">add price</a></li>
			</ul>
		</div>
		<div class="col-md-8 span8">
							<div class="content-box">
					<h1 class="page-title">
						{{ trans('products.creating_new_product') }}
					</h1>
					@if(Session::get('errors'))
					    <div class="alert alert-danger alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					         <h5>{{ trans('products.errors_while_creating') }}</h5>
					         @foreach($errors->all('<li>:message</li>') as $message)
					            {{$message}}
					         @endforeach
					    </div>
					@endif
					
					    <div class="form-group">
					    	<label for="name">{{ trans('products.name') }}</label>
					    	{{Form::text('name', null, array('class'=>'form-control','placeholder'=>trans('products.name_placeholder') ));}}
					    </div>
					    <div class="form-group">
					    	<label for="short_description">{{ trans('products.description') }}</label>
					    	{{Form::textarea('short_description',null, array('class'=>'form-control','placeholder'=>trans('products.products_description_placeholder'),'rows'=>'3'));}}
					    </div>
					    <div class="form-group">
					    	<label for="sku">{{ trans('products.sku') }}</label>
					    	{{Form::text('sku',null, array('class'=>'form-control','placeholder'=>trans('products.sku') ));}}
					    </div>
					     <div class="form-group">
					    	<label for="stock">{{ trans('products.stock') }}</label>
					    	{{Form::text('stock',null, array('class'=>'form-control','placeholder'=>trans('products.stock') ));}}
					    </div>
					     <div class="form-group">
					    	<label for="enabled">{{ trans('products.enabled') }} </label>
					    
					    {{ Form::select('enabled', array('1' => 'Enabled', '2' => 'Disabled')); }}
					    </div>
					
					    <div class="form-group">
					        <div class="text-right">
					          <button type="button" onclick="addProduct()"  id="save-section" class="btn btn-primary ladda-button" data-style="expand-right">
					            {{ trans('tricks.save_trick') }}
					          </button>
					        </div>
					    </div>
				
				</div>
		</div>
	</div>
@stop

