@section('title', 'board')
@section('styles')
<link
	rel="stylesheet"
	href="{{ URL::asset('css/highlight/laratricks.css') }}">
<link
	rel="stylesheet" href="{{ URL::asset('css/mysite.css') }}">
<link
	rel="stylesheet"
	href="{{ URL::asset('js/selectize/css/selectize.bootstrap3.css') }}">
<link
	rel="stylesheet" href="{{ URL::asset('css/jquery.Jcrop.min.css') }}">
	
<link
	rel="stylesheet" href="{{ URL::asset('css/jquery-ui-1.11.1.css') }}">
	
	
<style type="text/css">

#editor-content {
	position: relative;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	height: 300px;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	border: 1px solid #cccccc;
}
</style>
@stop 

@section('scripts')
<script
	src="{{ asset('js/jquery-ui-1.11.1.js') }}"></script>
<script
	src="{{ asset('js/jquery.validate.min.js') }}"></script>

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
	 enableSelectBoxes();
});

function enableSelectBoxes(){
	

    $('div.selectBox').each(function(){
    	$(this).children('span.selected').html($(this).children('div.selectOptions').children('span.selectOption:first').html());
    	$(this).attr('value',$(this).children('div.selectOptions').children('span.selectOption:first').attr('value'));
    	 $('#boards').attr('value',$(this).attr('value')); 

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
    	    $('#boards').attr('value',$(this).attr('value'));    	    
    	});
    	
    });
}

function createBoard() {
	$.ajax({ 
        url: "{{URL::route('board.create')}}",
        dataType: 'json', 
        data: {'board_name':$('#newboard').val(), _token:"{{ csrf_token() }}"} ,
        type: "POST", 
        success: function(output){ 
            console.log(output);
            var html = "<span class=\"selectOption\" value=\""+output.id + "\">"+output.board_name + "</span>";
            $( ".selectOptions" ).prepend(html);
        	$('div.selectBox').children('span.selected').html($('div.selectBox').children('div.selectOptions').children('span.selectOption:first').html());
        	$('div.selectBox').attr('value',$('div.selectBox').children('div.selectOptions').children('span.selectOption:first').attr('value'));
        	$('#boards').attr('value',output.id); 
                
        } 
    }); 
}


function addFile(){
	$("#dialog-add-file").dialog({
	    draggable: true,
	    resizable: true,
	    width: 400,
	  //  dialogClass: 'ui-dialog-osx',
	    buttons: {
	        "I've read and understand this": function() {
	            $(this).dialog("close");
	        }
	    }
	});
}

function getImage() {
	$("#image_form").validate({
		  rules: {
		    url:"url",
		  },
		  success: function(){
			  $('#image-preview').attr("src", $('#image_file_url').val());
			  $('#image-hidden').attr("value",$('#image_file_url').val());
			 $("#dialog-add-file").dialog("close");
			  }   
	});  	
}



</script>
@stop 


@section('content')
<div class="container">
	<div class="row">
		<div
			class="col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 col-sm-12 col-xs-12">
			<div class="content-box">
				<h1 class="page-title">{{ trans('board.creating_new_board') }}</h1>
				@if(Session::get('errors'))
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert"
						aria-hidden="true">&times;</button>
					<h5>{{ trans('tricks.errors_while_creating') }}</h5>
					@foreach($errors->all('
					<li>:message</li>') as $message) {{$message}} @endforeach
				</div>
				@endif {{
				Form::open(array('class'=>'form-vertical','id'=>'save-board-form','role'=>'form'))}}
				<div class="form-group">{{Form::text('image_name', null,
					array('class'=>'form-control','placeholder'=>trans('board.title_placeholder')
					));}}</div>

				<div class="form-group">
					<div class="col-lg-8">
						<input type="hidden" id="image-hidden" name="image_path" value="">
						<div id="upload-image" class="upload-avatar">
							<div class="userpic">
								<img id="image-preview" class="image-preview">		
								</div>
							</div>
							<div class="btn btn-primary" onclick="addFile()">
								<div class="">
									<span class="btn-txt">{{ trans('user.choose') }}</span> 
									<input type="button" name="image_url" >
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



				<div class="form-group">{{Form::textarea('description',null,
					array('class'=>'form-control','placeholder'=>trans('board.board_description_placeholder'),'rows'=>'3'));}}
				</div>
				

	
				<div class="form-group" hidden=true >{{Form::text('boards', null,
					array('class'=>'form-control','id'=>'boards', 'placeholder'=>trans('board.title_placeholder')
					));}}</div>


<div class="form-group">
	<div class='selectBox'>
		<span class='selected' id="selectedBox"></span>
		<span class='selectArrow'>&#9660</span>
		<div class="selectOptions">
		@foreach ($boardList as $key=>$value)
			<span class="selectOption" value="{{$key}}"> {{$value}}</span>
		@endforeach
			<div class="addBoard">
				<input type="text" id=newboard>
				<input type="button" id="createBtn" value="create board" onclick="createBoard()">
			</div>
		</div>
  	</div>
</div>
				


				<div class="form-group">
					<div class="text-right">
						<button type="submit" id="save-section"
							class="btn btn-primary ladda-button" data-style="expand-right">
							{{ trans('board.save_board') }}</button>
					</div>
				</div>
				{{Form::close()}}
			</div>
		</div>
	</div>
	
		<div id="dialog-add-file" title="add a file from internet" hidden="true">
		<div class="description" id="add_board">
			<form id="image_form">
			<input type="text" placeholder="http://" id="image_file_url" class="url" value="11" >
			<input type="button" value="confirm" onclick="getImage()">
			</form>
		</div>
		
		<div class="image-preview">
		<img id="image-preview">
		</div>

	</div>
	
</div>
@stop
tn