<?php

namespace Tricks\Providers;

use Illuminate\Support\ServiceProvider;
use Tricks\Services\Upload\ImageUploadService;
use Tricks\Services\Wechat2\Wechat2;

class Wechat2ServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
       
        	$this->app['test2'] = $this->app->share(function ($app) {
        		return new Wechat2;
        	});
    }
}
