<?php namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model {
	
	protected $table = "portfolio";
	
	public $presenter  = "Tricks\Presenters\PortfolioPresenter";
	

	
	
	/**
	 * Query the user that created the portfolio.
	 */
	public function user()
	{
		return $this->belongsTo('Tricks\User');
	}
	


	public function portfolioItems() {
		return $this->hasMany('Tricks\PortfolioItem');
	}
	
	/*
	public function portfolioHistoryItems() {
		return $this->hasMany('Tricks\PortfolioHistoryItem');
	}
	*/

	/**
	 * User followers relationship
	 */
	public function accounts() {
		return $this->hasMany('Tricks\Account');
	}
	
}