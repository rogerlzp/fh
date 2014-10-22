<?php

namespace Tricks\Facades;

use Illuminate\Support\Facades\Facade;

class WechatServer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'wechatserver';
    }
}
