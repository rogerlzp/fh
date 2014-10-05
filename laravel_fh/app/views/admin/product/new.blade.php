@section('scripts')
<script type="text/javascript">
  var FileAPI = {
          debug: false
          , staticPath: "{{ url('js/vendor/uploader') }}/"
          , postNameConcat: function (name, idx){
        return  name + (idx != null ? '['+ idx +']' : '');
      }
  };

  
</script>

<script
	src="{{ asset('js/vendor/uploader/FileAPI.min.js') }}"></script>
<script
	src="{{ asset('js/vendor/uploader/FileAPI.exif.js') }}"></script>
<script
	src="{{ asset('js/vendor/uploader/jquery.fileapi.js') }}"></script>
<script
	src="{{ asset('js/vendor/uploader/jquery.Jcrop.min.js') }}"></script>

<script type="text/javascript">
jQuery(function ($){
	 $('#upload-image').fileapi({
	     url: '{{ route("image.upload") }}',
	     accept: 'image/*',
	     data: { _token: "{{ csrf_token() }}" },
	     imageSize: { minWidth: 200, minHeight: 200 },
	     elements: {
	        active: { show: '.js-upload', hide: '.js-browse' },
	        preview: {
	           el: '.js-preview',
	           width: 100,
	           height: 100
	        },
	        progress: '.js-progress'
	     },
	     autoUpload: true,

	     onSelect: function (evt, ui){
	        var file = ui.all[0];
	        if( file ){
	          $('#cropper-preview').show();
	          $('.js-img').cropper({
	             file: file,
	             bgColor: '#fff',
	             maxSize: [$('#cropper-preview').width(), $(window).height()],
	             minSize: [100, 100],
	             selection: '90%',
	             aspectRatio: 1,
	             onSelect: function (coords){
	                $('#upload-image').fileapi('crop', file, coords);
	             }
	          });
	        }
	     },

	    onComplete: function(evt, xhr)
	     {
	      try {
	        var result = FileAPI.parseJSON(xhr.xhr.responseText);
	        $('#image-hidden').attr("value",result.images.filename);
	      } catch (er){
	        FileAPI.log('PARSE ERROR:', er.message);
	      }
	     }
	  });

});

function addProduct() {
$.ajax({ 
        url: "{{URL::route('admin.product.create')}}",
        dataType: 'json', 
        data: {'name':$("input[name='name']").val(), 'short_description':$("textarea[name='short_description']").val(),
        'sku':$("input[name='sku']").val(),'stock':$("input[name='stock']").val(), _token: "{{ csrf_token() }}"} ,
        type: "POST", 
        success: function(output){ 
           var html="<input class=\"form-control\" value=\""+output.id +"\" name=\"id\" type=\"hidden\">";
           $('#basic_info').append(html);
           $('#basic_info').hide();
           $('#images').show();
           $('#basic_menu').removeClass('active');
           $('#mage_menu').addClass('active');
        } ,
        error: function(error1) {
			alert(error1.id);
            }
    }); 
}

function updateImage() {
	$.ajax({ 
	        url: "{{URL::route('admin.product.updateImage')}}",
	        dataType: 'json', 
	        data: {'product_id':$("input[name='id']").val(), 'image_path':$("#image-hidden").val(),
	         _token: "{{ csrf_token() }}"} ,
	        type: "POST", 
	        success: function(product){ 
	           $('#images').hide();
	           $('#price').show();
	           $('#image_menu').removeClass('active');
	           $('#price_menu').addClass('active');
	           
	        } 
	    }); 
	}

function updatePrice() {
	$.ajax({ 
	        url: "{{URL::route('admin.product.updateprice')}}",
	        dataType: 'json', 
	        data: {'product_id':$("input[name='id']").val(), 'price':$("input[name='price']").val(),
	         _token: "{{ csrf_token() }}"} ,
	        type: "POST", 
	        success: function(product){ 
	                     
	        } 
	    }); 
	}
	

function showBasic() {
	 $('#images').hide();
	 $('#basic_info').show();
	 $('#basic_menu').addClass('active');
	 
}


function showImage() {
	 $('#basic_info').hide();
	 $('#images').show();
	 $('#basic_menu').removeClass('active');
	 $('#image_menu').addClass('active');
}


function showPrice() {
	 $('#basic_info').hide();
	 $('#images').hide();
	 $('#price').show();
	 $('#basic_menu').removeClass('active');
	 $('#image_menu').removeClass('active');
	 $('#price_menu').addClass('active');
	 
}

</script>
@stop

@section('content')

<div class="”container”">
	<div class="row">
	<div class="col-md-1" ></div>
		<div class="col-md-3 span4" >
			<ul class="nav nav-list">
				<li class="nav-header">What we are?</li>
				<li class="active" id="basic_menu" onclick="showBasic()"><a href="#">Basic Information</a></li>
				<li id="image_menu" onclick="showImage()"><a href="#">add image</a></li>
				<li id="price_menu" onclick="showPrice()"><a href="#">add price</a></li>
				<li><a href="#">add price</a></li>
			</ul>
		</div>
		<div class="col-md-8 span8">
				<div class="content-box" id="basic_info">
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
					    	<input class="form-control" placeholder="{{trans('products.name_placeholder')}}" name="name" type="text">
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
					          <button type="button" onclick="addProduct()"   class="btn btn-primary" data-style="expand-right">
					            {{ trans('tricks.save_trick') }}
					          </button>
					        </div>
					    </div>
				</div>
				
				<div class="content-box" id="images" hidden="true">
					<div class="form-group">
					<div class="col-lg-8">
						<input type="hidden" id="image-hidden" name="image_path" value="">
						<div id="upload-image" class="upload-avatar">
							<div class="userpic">
								<div class="js-preview userpic__preview"></div>
							</div>
							<div class="btn btn-sm btn-primary js-fileapi-wrapper">
								<div class="js-browse">
									<span class="btn-txt">{{ trans('user.choose') }}</span> 
									<input type="file" name="filedata">
								</div>					
								<div class="js-upload" style="display: none;">
									<div class="progress progress-success">
										<div class="js-progress bar"></div>
									</div>
									<span class="btn-txt">{{ trans('user.uploading') }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="text-right">
						<button type="submit" id="save-section" onclick="updateImage()"
							class="btn btn-primary ladda-button" data-style="expand-right">
							{{ trans('board.save_board') }}</button>
					</div>
				</div>
				
				</div>
				
				
					<div class="content-box" id="price" hidden="true">
					<div class="form-group">
					<label for="stock">{{ trans('products.price') }}</label>
					
<input class="form-control" placeholder="Price:" name="price" type="text">					
					 
					</div>
				
				<div class="form-group">
					<div class="text-right">
						<button type="submit" id="save-section" onclick="updatePrice()"
							class="btn btn-primary ladda-button" data-style="expand-right">
							{{ trans('board.save_board') }}</button>
					</div>
				</div>
				
				</div>
		</div>
	</div>
@stop

