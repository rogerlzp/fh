<?php

namespace Controllers;
use Cooper\Wechat\WeChatServer;
use Illuminate\Support\Facades\Log;

use Tricks\Repositories\ActivityRepositoryInterface;
use Illuminate\Support\Facades\Input;


class WeixinController extends BaseController
{
    /**
     * Activity repository.
     *
     * @var \Tricks\Repositories\ActivityRepositoryInterface
     */
 //   protected $activity;

    /**
     * Create a new HomeController instance.
     *
     * @param  \Tricks\Repositories\ActivityRepositoryInterface  $activity
     * @return void
     */
  /*  public function __construct()
    {
      //  parent::__construct();
        
        $this->beforeFilter('weixin', array('on' => 'get|post'));
        
   //     $this->activity = $activity;
    }
    */
    
    public function __construct(WeChatServer $weChatServer)
    //public function __construct()
    {
    	// $this->weChatServer = $weChatServer;
    	parent::__construct();
    }
    

    /**
     * Show the homepage.
     *
     * @return \Response
     */
  /*  public function index()
    {
    	return Input::get('echostr');
      //  $activities = $this->activity->findAllPaginated();

       // $this->view('home.index', compact('activities'));
    }
*/
    
    /**
     * 测试微信功能
     */
    function test()
    {
    	echo "hello";
    	Log::info('test in WechatController');
    	//	dd($this->weChatServer->getMessage());
    
    	//echo WeChatServer::getXml4Txt('abc');
    
    	// exit;
    }
    
    /**
     * Show the about page.
     *
     * @return \Response
     */
    public function getAbout()
    {
        $this->view('home.about');
    }
}
