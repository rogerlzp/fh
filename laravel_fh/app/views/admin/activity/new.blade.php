@section('scripts')
<script type="text/javascript" src="{{url('js/vendor/jquery-ui-1.10.3.custom.min.js')}}"></script>
<script type="text/javascript">

</script>
@stop

@section('content')
<!-- Modal -->
 <div  id="add_activity" tabindex="-1" >
   <div class="">
     <div class="">
       <div class="">
         <button type="button" class="close" >&times;</button>
         <h4 class="">{{ trans('admin.add_new_activity') }}</h4>
       </div>
       <div class="">
       		@if($errors->all())
       		    <div class="bs-callout bs-callout-danger">
       		        <h4>{{ trans('admin.please_fix_errors') }}</h4>
       		        {{ HTML::ul($errors->all())}}
       		    </div>
       		@endif
			{{ Form::open(array('class'=>'form-horizontal', 'url'=> route('admin.activity.create') ))}}
        	<div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.title') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('title',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
        	<div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.topic') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('topic',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
            <div class="form-group">
                <label for="url" class="col-lg-2 control-label">{{ trans('admin.description') }}</label>
                <div class="col-lg-10">
                    {{ Form::textarea('description',null,array('class'=>'form-control','rows'=>'4'))}}
                </div>
            </div>
            <div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.startDate') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('startDate',null,array('class'=>'form-control', 'data-datepicker' => 'datepicker'))}}
        	    </div>
        	</div>
        	<div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.endDate') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('endDate',null,array('class'=>'form-control', 'data-datepicker' => 'datepicker'))}}
        	    </div>
        	</div>
        	<div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.address') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('address',null,array('class'=>'form-control', 'data-datepicker' => 'datepicker'))}}
        	    </div>
        	</div>
        	  <div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.join_endtime') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('join_endtime',null,array('class'=>'form-control', 'data-datepicker' => 'datepicker'))}}
        	    </div>
        	</div>
        	<div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.traffic') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('traffic',null,array('class'=>'form-control', 'data-datepicker' => 'datepicker'))}}
        	    </div>
        	</div>
        	 <div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.yy') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('yy',null,array('class'=>'form-control', 'data-datepicker' => 'datepicker'))}}
        	    </div>
        	</div>
        	 <div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.note') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('note',null,array('class'=>'form-control', 'data-datepicker' => 'datepicker'))}}
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
 