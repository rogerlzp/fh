@section('title', trans('admin.editing_role'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-6"> 
			<div class="page-header">
			  	<h1>{{ trans('admin.editing_a_role') }} <a href="{{ url('admin/role')}}" class="btn btn-lg btn-default pull-right">{{ trans('admin.cancel') }}</a></h1>
			</div>

            @if($errors->all())
                <div class="bs-callout bs-callout-danger">
                    <h4>{{ trans('admin.please_fix_errors') }}</h4>
                    {{ HTML::ul($errors->all())}}
                </div>
            @endif

			{{ Form::model($role,array('class'=>'form-horizontal'))}}
        	<div class="form-group">
        	    <label for="name" class="col-lg-2 control-label">{{ trans('admin.name') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('name',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.description') }}</label>
                <div class="col-lg-10">
                    {{ Form::text('description',null,array('class'=>'form-control','rows'=>'5'))}}
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.permission') }}</label>
                <div class="col-lg-10">
					{{ Form::select('permissions[]', $permissions, $spermissions, 
					array('multiple','id'=>'permissions','placeholder'=>trans('tricks.tag_trick_placeholder'),'class' => 'form-control')); }}
				 </div>
			</div>
			
        	<div class="form-group">
        		<div class="col-lg-10 col-lg-offset-2">
        		{{ Form::submit( trans('admin.save_role') ,array('class'=>'btn btn-primary btn-block')); }}
        		</div>
        	</div>
        	{{ Form::close()}}
	    </div>
	</div>
</div>
@stop