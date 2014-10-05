<?php 

namespace Controllers\Admin;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;



class AdminController extends BaseController {
	

	public function __construct()
	{
		parent::__construct();
	}
	
    public function getLogin()
    {
    	$title = 'Foldagram - Admin';
    //	$this->view('admin.layouts.login',compact('title'));
        return View::make('admin.layouts.login')->with('title','Foldagram - Admin');
    }
    
    public function getIndex() {
    	$title = 'Foldagram - Admin';
    	$this->view('admin.layouts.test1',compact('title'));
    }
}

