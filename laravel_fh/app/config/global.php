<?php  

App::missing(function($e) {
	$url = Request::fullUrl();
	Log::warning("404 for URL: $url");
	return Response::view('errors.not-found', array(), 404);
});

