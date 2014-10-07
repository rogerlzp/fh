@section('title', trans('admin.editing_user'))

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-6"> 
			<div class="page-header">
			  	<h1>{{ trans('admin.editing_a_user') }} <a href="{{ url('admin/user')}}" class="btn btn-lg btn-default pull-right">{{ trans('admin.cancel') }}</a></h1>
			</div>

            @if($errors->all())
                <div class="bs-callout bs-callout-danger">
                    <h4>{{ trans('admin.please_fix_errors') }}</h4>
                    {{ HTML::ul($errors->all())}}
                </div>
            @endif

			{{ Form::model($user,array('class'=>'form-horizontal'))}}
        	<div class="form-group">
        	    <label for="name" class="col-lg-2 control-label">{{ trans('admin.username') }}</label>
        	    <div class="col-lg-10">
        	    	{{ Form::text('username',null,array('class'=>'form-control'))}}
        	    </div>
        	</div>
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.email') }}</label>
                <div class="col-lg-10">
                    {{ Form::text('email',null,array('class'=>'form-control'))}}
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.role') }}</label>
                <div class="col-lg-10">
					{{ Form::select('roles[]', $roles, $sroles, 
					array('multiple','id'=>'roles','placeholder'=>trans('tricks.tag_trick_placeholder'),'class' => 'form-control')); }}
				 </div>
			</div>
			
			<div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.name') }}</label>
                <div class="col-lg-10">
                <input class="form-control" name="username" type="text" value="{{$user->profile->name}}">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.mobile') }}</label>
                <div class="col-lg-10">
                 {{ Form::text('mobile',null,array('class'=>'form-control'))}}
                </div>
            </div>
            
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.company') }}</label>
                <div class="col-lg-10">
                <input class="form-control" name="company" type="text" value="{{$user->profile->company}}">
                </div>
            </div>
			
			<div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.department') }}</label>
                <div class="col-lg-10">
                <input class="form-control" name="department" type="text" value="{{$user->profile->department}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.job') }}</label>
                <div class="col-lg-10">
                <input class="form-control" name="title" type="text" value="{{$user->profile->title}}">
                </div>
            </div>
            
             <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.address') }}</label>
                <div class="col-lg-10">
                <input class="form-control" name="address" type="text" value="{{$user->profile->address}}">
                </div>
            </div>
            
              <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.phone') }}</label>
                <div class="col-lg-10">
                <input class="form-control" name="phone" type="text" value="{{$user->profile->phone}}">
                </div>
            </div>
            
               <div class="form-group">
                <label for="description" class="col-lg-2 control-label">{{ trans('admin.source') }}</label>
                <div class="col-lg-10">
                <input class="form-control" name="phone" type="text" value="{{$user->is_online}}">
                </div>
            </div>
			
        	<div class="form-group">
        		<div class="col-lg-10 col-lg-offset-2">
        		{{ Form::submit( trans('admin.save_user') ,array('class'=>'btn btn-primary btn-block')); }}
        		</div>
        	</div>
        	{{ Form::close()}}
	    </div>
	</div>
</div>
@stop