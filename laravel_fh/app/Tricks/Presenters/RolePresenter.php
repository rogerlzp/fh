<?php namespace Tricks\Presenters;

use Tricks\Role;
use McCool\LaravelAutoPresenter\BasePresenter;
use Illuminate\Support\Facades\Log;

class RolePresenter extends BasePresenter {
	

	
	
	public function __construct(Role $role)
	{
		$this->resource = $role;
	}
	
	

}

