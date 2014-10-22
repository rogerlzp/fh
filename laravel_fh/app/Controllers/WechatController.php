<?php

namespace Controllers;
use WechatServer;
use ImageUpload;
use Wechat2;
use Illuminate\Support\Facades\Log;

use Tricks\Repositories\ActivityRepositoryInterface;
use Illuminate\Support\Facades\Input;


class WechatController extends BaseController
{
	
	/**
	 * 微信
	 *

	 */
	protected $wechat2;
	
	/**
	 * 构造函数
	 *
	 * @param WeChatServer $weChatSeruse Illuminate\Support\Facades\Log;ver
	 */
	public function __construct(Wechat2 $wechat2)
//	public function __construct()
	{
		 $this->wechat2 = $wechat2;
	//	$this->weChatServer  = $app['wechatserver'];
		parent::__construct();
	}
	
	/**
	 * 测试微信功能
	 */
	function test()
	{
		echo "helloabcde";
		Log::info('test in WechatController');
		//ImageUpload::hello();
	//	WechatServer::hello();
	//	Wechat2::hello();
		$this->wechat2->hello();
	
		//echo WeChatServer::getXml4Txt('abc');
	
		// exit;
	}
	
	

}