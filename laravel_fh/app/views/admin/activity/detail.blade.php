@section('title', trans('admin.editing_activity'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-6"> 
			<div class="page-header">
			  	<h1>{{ trans('admin.editing_a_category') }} <a href="{{ url('admin/activity')}}" class="btn btn-lg btn-default pull-right">{{ trans('admin.cancel') }}</a></h1>
			</div>

            @if($errors->all())
                <div class="bs-callout bs-callout-danger">
                    <h4>{{ trans('admin.please_fix_errors') }}</h4>
                    {{ HTML::ul($errors->all())}}
                </div>
            @endif

			{{ Form::model($activity,array('class'=>'form-horizontal'))}}
        	<div class="form-group">
        	    <label for="name" class="col-lg-2 control-label">{{ trans('admin.name') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('title',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.description') }}</label>
                <div class="col-lg-10">
                    {{ Form::textarea('description',null,array('class'=>'form-control','rows'=>'5'))}}
                </div>
            </div>
        	<div class="form-group">
        		<div class="col-lg-10 col-lg-offset-2">
        		{{ Form::submit( trans('admin.save_category') ,array('class'=>'btn btn-primary btn-block')); }}
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
        	{{ Form::close()}}
	    </div>
	</div>
</div>
@stop