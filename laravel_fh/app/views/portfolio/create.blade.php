@section('scripts')
<script type="text/javascript" src="{{url('js/vendor/jquery-ui-1.10.3.custom.min.js')}}"></script>
<script type="text/javascript">

</script>
@stop

@section('content')
 <div  id="add_activity" tabindex="-1" >
   <div class="">
     <div class="">
       <div class="">
         <h4 class="">{{ trans('portfolio.create_portfolio') }}</h4>
       </div>
       <div class="">
       		@if($errors->all())
       		    <div class="bs-callout bs-callout-danger">
       		        <h4>{{ trans('admin.please_fix_errors') }}</h4>
       		        {{ HTML::ul($errors->all())}}
       		    </div>
       		@endif
			{{ Form::open(array('class'=>'form-horizontal', 'url'=> route('portfolio.create') ))}}
        	<div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('portfolio.name') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('name',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
        	<div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('portfolio.description') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('description',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
           
        	<div class="form-group">
        		<div class="col-lg-10 col-lg-offset-2">
        		{{ Form::submit('Create',array('class'=>'btn btn-lg btn-primary btn-block')); }}
        		</div>
        	</div>
        	{{ Form::close()}}
       </div>
     </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->
 
 @stop
 