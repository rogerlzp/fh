@section('title', trans('admin.viewing_activity'))

@section('content')
<div>
{{ Form::model($activity, array('class'=>'form-horizontal', 'url'=> route('admin.activity.edit')))}}
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
        	    	{{ Form::text('address',null,array('class'=>'form-control'))}}
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
        	    	{{ Form::text('traffic',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
        	 <div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.yy') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('yy',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
        	 <div class="form-group">
        	    <label for="title" class="col-lg-2 control-label">{{ trans('admin.note') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('note',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
            
             <div class="form-group">
        		<div class="col-lg-10 col-lg-offset-2">
        		<p> test</p>
					    	<p>{{ Form::select('tags[]', $tagList, null, array('multiple','id'=>'tags','placeholder'=>trans('tricks.tag_trick_placeholder'),'class' => 'form-control')); }}</p>
	          </div>
	           </div>
			<div class="form-group">
				<div class="col-lg-10 col-lg-offset-2">
					    	<p>{{ Form::select('categories[]', $categoryList, null, array('multiple','id'=>'categories','placeholder'=>trans('tricks.categorize_trick_placeholder'),'class' => 'form-control')); }}</p>
					    </div>
        		</div>
            
        	<div class="form-group">
        		<div class="col-lg-10 col-lg-offset-2">
        		{{ Form::submit('Update',array('class'=>'btn btn-lg btn-primary btn-block')); }}
        		</div>
        	</div>
        	{{ Form::close()}}
       </div>
 @stop