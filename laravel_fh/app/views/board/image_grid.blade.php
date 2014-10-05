

<link
	rel="stylesheet" href="{{ URL::asset('css/jquery-ui-1.11.1.css') }}">


<script
	src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<script
	src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
<script
	src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
<script
	src="{{ asset('js/jquery.infinitescroll.min.js') }}"></script>

<script
	src="{{ asset('js/jquery-ui-1.11.1.js') }}"></script>


<script type="text/javascript">
jQuery(document).ready( function($) {
	
	$('#image_container').imagesLoaded( function() {
		  $('#image_container').masonry({
			  itemSelector: '#image_wrapper',
		        columnWidth : 240 
			  });
		});

	  $('#image_container').infinitescroll({
          navSelector     : ".pagination",
          nextSelector    : ".pagination a:last",
          itemSelector    : "#image_wrapper",
          debug           : false,
          dataType        : 'html',
          path: function(index) {
              return "?page=" + index;
          },
          loading: {
              finishedMsg: ""
          }
      }, function(newElements, data, url){
          var $newElems = $( newElements );
          $newElems.imagesLoaded(function(){
          $('#image_container').masonry( 'appended', $newElems, false);
          });

      });

	  $('.pagination').hide();

	  // Show edit-buttons only on mouse over
	    $('#image_wrapper').each(function(){
	        var thisPin = $(this);
	        thisPin.find('.editable').hide();
	        thisPin.find('.like').hide();
	        thisPin.off('hover');
	        thisPin.hover(function() {
	            thisPin.find('.editable').stop(true, true).fadeIn(300);
	            thisPin.find('.like').stop(true, true).fadeIn(300);
 
	        }, function() {
	            thisPin.find('.editable').stop(true, false).fadeOut(300);
	            thisPin.find('.like').stop(true, false).fadeOut(300);
	        });
	    });
	      

});


function addPin(image_id){	

	$.ajax({ 
        url: "{{URL::route('user.board2')}}",
        dataType: 'json', 
        data: {user_id:1} ,
        type: "POST", 
        success: function(output){ 
            alert(output);
        } 
    }); 


	
	$("#dialog-message").dialog({
	    modal: true,
	    draggable: true,
	    resizable: true,
	    width: 400,
	    dialogClass: 'ui-dialog-osx',
	    buttons: {
	        "I've read and understand this": function() {
	            $(this).dialog("close");
	        }
	    }
	});

}
function login(){
	window.location.href = "/login";
}
function pinImage(board_id, image_id) {
	$.ajax({ 
        url: "{{URL::route('image.pin')}}",
        dataType: 'json', 
        data: {'board_id':board_id, 'image_id':image_id} ,
        type: "POST", 
        success: function(output){ 
            alert(output);
        } 
    }); 
	
}

function addLike(image_id, object){		
	if(object.value=="like") {
		alert("like");
	$.ajax({ 
        url: "{{URL::route('user.like')}}",
        dataType: 'json', 
        data: {'image_id':image_id, _token: "{{ csrf_token() }}"} ,
        type: "POST", 
        success: function(output){ 
        	object.value="dislike";
        }
	});
	} else {
		alert("dislike");
		$.ajax({ 
	        url: "{{URL::route('user.dislike')}}",
	        dataType: 'json', 
	        data: {'image_id':image_id, _token: "{{ csrf_token() }}"} ,
	        type: "POST", 
	        success: function(output){ 
	        	object.value="like";
	        }
		});

	}
}
        	
        	 
function addPinTest(image_id, image_path){	
	
	$.ajax({ 
        url: "{{URL::route('user.board2')}}",
        dataType: 'json', 
        type: "GET", 
        success: function(output){ 
        	 for(var i in output){
        		 $("#boards").append(new Option(output[i].board_name, output[i].id));
            }
        	 $('#image-preview').attr("a", "b" );
             	$('#image-preview').attr("src", "{{URL::asset('img/temp/')}}"+"/"+image_path );
        		$("#dialog-message").dialog({
        		    modal: true,
        		    draggable: true,
        		    resizable: true,
        		    width: 400,
        		    dialogClass: 'ui-dialog-osx',
        		    buttons: {
        		        "add pin": function() {
        		        	$.ajax({ 
        		                url: "{{URL::route('image.pin')}}",
        		                dataType: 'json', 
        		                data: {'board_id': $("#boards").val(), 'image_id':image_id} ,
        		                success: function(output){ 
        		                	 window.location.href = "/login";
        		                } 
        		            }); 
        		            $(this).dialog("close");
        		        }
        		    }
        		});
			
        		
        } 
    }); 
}




</script>


<div class="content-box">
	<div id="image_container">
		<div id="list">

			@if ( Auth::check() ) 
			@foreach($images as $image)
		<div id="image_wrapper" >
			<div>
				<a href="{{$image->id}}"> <img class="item"
					src="{{ URL::asset('img/temp/'.$image->image_path) }}">
				</a>
				
				<div class="trick-card-stats clearfix">
					<div>likes("{{$image->likedcounter()}}")</div>
					</div>
				
			</div>
			</div>
		@endforeach 
		@endif
	</div>





	<div class="col-span-12">
		<div class="paginate text-center"></div>
	</div>
</div>


<div id="dialog-message" title="add to  board" hidden="true">
	<div class="dialog-field">
		<label for="board">pick a board:</label> <select id="boards"></select>
		<div class="ui-helper-clearfix"></div>
	</div>

	<div class="description" id="add_board">
		<input type="text" placeholder="add some desc">
	</div>

	<div class="image-preview">
		<img id="image-preview">
	</div>

</div>



</div>



