<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
    <head>
        @section('description', trans('layouts.meta_description'))
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta property="og:title" content="" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />
        <meta property="og:site_name" content="" />
        <meta property="og:description" content="@yield('description')" />
        <meta name="description" content="@yield('description')">
        <meta name="author" content="{{ trans('layouts.meta_author') }}">
        <title>
		@yield('title') 
		| 
		{{ trans('layouts.site_title') }}
	</title>
        <link rel="stylesheet" href="{{ URL::asset('css/laratricks.min.css') }}">
         <link rel="stylesheet" href="{{ URL::asset('css/mysite.css') }}">
        <link href="{{ asset('css/font-awesome/font-awesome.css') }}" rel="stylesheet">
        @yield('styles')
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.2.0/respond.js"></script>
        <![endif]-->
        
        <script
	src="{{ asset('js/tmpcdn/jquery-1.11.1.min.js') }}"></script>
	  <script
	src="{{ asset('js/tmpcdn/bootstrap.min.js') }}"></script>


	
    </head>

    <body>
        <div id="wrap">
 <div class="container">
        <div class="row">
            <div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
                <div class="content-box login-form">
                    <h1 class="page-title">{{ trans('home.login_title') }}</h1>
                    @if(Session::get('login_errors'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>{{ trans('home.email_or_password_incorrect') }}</h5>
                        </div>
                    @endif

                    @if(Session::has('password_reset'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			    <h5>{{ trans('home.password_has_been_reset') }}</h5>
                        </div>
                    @endif

                    {{ Form::open(['route' => 'auth.adminlogin']) }}
                        <div class="form-group">
                            {{ Form::label('username', 'Username', [ 'class' => 'control-label' ]) }}
                            {{ Form::text('username', null, ['class'=>'form-control', 'placeholder' => trans('home.username_placeholder')])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Password', [ 'class' => 'control-label' ]) }}
                            {{ Form::password('password', ['class'=>'form-control', 'placeholder'=>trans('home.password_placeholder')])}}
                        </div>
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('remember') }} {{ trans('home.remember_me') }}
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-login">{{ trans('home.login') }}</button>
                        </div>
                    {{ Form::close() }}

                    <ul class="nav nav-list">
                        <li class="text-center"><a href="{{ url('password/remind') }}">{{ trans('home.forgot_your_password') }}</a></li>
                        <li class="text-center"><a href="{{ url('register') }}">{{ trans('home.do_not_have_account_yet') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
        </div>

        @include('admin.partial.footer')

      

        @yield('scripts')

    </body>
</html>






 
    
    
            