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
            @include('admin.partial.navigation')
            @yield('content')
        </div>

        @include('admin.partial.footer')

      

        @yield('scripts')

    </body>
</html>
