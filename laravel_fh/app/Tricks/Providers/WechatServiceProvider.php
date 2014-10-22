<?php namespace Tricks\Providers;

use Illuminate\Support\ServiceProvider;
use Tricks\Services\Wechat\WechatServer;

class WechatServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app['wechatserver'] = $this->app->share(function ($app) {
			return new Tricks\Services\Wechat\WechatServer;
		});
		
		/*
		
			$this->app->bind('wechat.server', function()
			{
				return new WechatServer;
			});
			*/
	}

}
