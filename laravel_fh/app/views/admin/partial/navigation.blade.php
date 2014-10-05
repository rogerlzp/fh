<div class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".header-collapse">
				<span class="sr-only">{{ trans('partials.toggle_navigation') }}</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<a class="navbar-brand" href="{{ url('/') }}">
				<img width="207" height="50" src="{{ asset('img/logo@2x.png') }}">
			</a>
		</div>

		<div class="collapse navbar-collapse header-collapse">
			<ul class="nav navbar-nav">
			

			
				<li class="dropdown" >
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('admin.manage_activity') }} <b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
				<li> <a href="{{URL::route('admin.activity.create') }}">{{ trans('admin.add_new_activity')}}</a></li>
				<li> <a href="{{URL::route('admin.activity.index') }}">{{ trans('admin.view_activity')}}</a></li>
			    </ul>
			    </li>
			    <li><a href="{{ URL::route('admin.categories.index') }}">{{ trans('admin.manage_category') }}</a></li>	    
			    <li><a href="{{ URL::route('admin.tags.index') }}">{{ trans('admin.manage_tag') }}</a></li>
			    
			    <li><a href="{{ URL::route('admin.users.index') }}">{{ trans('admin.manage_user') }}</a></li>
				
				

				@if(Auth::guest())
					<li class="visible-xs"><a href="{{ url('register') }}">{{ trans('partials.register') }}</a></li>
					<li class="visible-xs"><a href="{{ url('login') }}">{{ trans('partials.login') }}</a></li>
				@else
					<li class="visible-xs"><a href="{{ url('user') }}">{{ trans('partials.my_profile') }}</a></li>
					<li class="visible-xs"><a href="{{ url('logout') }}">{{ trans('partials.logout') }}</a></li>
				@endif

			</ul>


		</div>

	</div>
</div>
