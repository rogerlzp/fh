<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function ($request) {
	//
});


App::after(function ($request, $response) {
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/


Route::filter('admin', function () {
	if (Auth::guest() || (Auth::check() && ! Auth::user()->isAdmin())) {
		return Redirect::guest('login');
	}
});

Route::filter('auth', function() {
	if (Auth::guest()) {
		return Redirect::guest('login');
	}
});


Route::filter('auth.basic', function () {
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function () {
	if (Auth::check()) {
		return Redirect::to('/');
	}
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
	if (Session::token() != Input::get('_token')) {
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('trick.view_throttle', 'Tricks\Filters\ViewThrottleFilter');
Route::filter('trick.owner', 'Tricks\Filters\TrickOwnerFilter');


Route::filter('weixin', function()
{
	// 获取到微信请求里包含的几项内容
	$signature = Input::get('signature');
	$timestamp = Input::get('timestamp');
	$nonce     = Input::get('nonce');

	// financehouse 是我在微信后台手工添加的 token 的值
	$token = 'financehouse';

	// 加工出自己的 signature
	$our_signature = array($token, $timestamp, $nonce);
	sort($our_signature, SORT_STRING);
	$our_signature = implode($our_signature);
	$our_signature = sha1($our_signature);

	// 用自己的 signature 去跟请求里的 signature 对比
	if ($our_signature != $signature) {
	//	return false;
	}
	
});

Route::filter('auth.wechat', function ($route, $request, $userRule = NULL)
{

});

