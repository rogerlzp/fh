<?php namespace Tricks\Presenters;

use Tricks\Permission;
use McCool\LaravelAutoPresenter\BasePresenter;
use Illuminate\Support\Facades\Log;

class PermissionPresenter extends BasePresenter {
	

	
	
	public function __construct(Permission $permission)
	{
		$this->resource = $permission;
	}
	
	

}

