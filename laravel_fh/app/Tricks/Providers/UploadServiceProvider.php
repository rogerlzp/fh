<?php

namespace Tricks\Providers;

use Illuminate\Support\ServiceProvider;
use Tricks\Services\Upload\ImageUploadService;
use Tricks\Services\Upload\Test2;

class UploadServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['upload.image'] = $this->app->share(function ($app) {
            return new ImageUploadService($app['files']);
        });
        
    }
}
