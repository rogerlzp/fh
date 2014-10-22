<?php namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {
	
	protected $table = "account";
	
//	public $presenter  = "Tricks\Presenters\AccountPresenter";
	

	
	
	/**
	 * Query the user that created the portfolio.
	 */
	public function portfolio()
	{
		return $this->belongsTo('Tricks\Portfolio');
	}
	
}