<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock';

	/**
	 * The class used to present the model.
	 *
	 * @var string
	 */
	 public $presenter = 'Tricks\Presenters\StockPresenter';

	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
	# protected $with = [ 'current_price' ];

	
	/**
	 * Relationship with Portfolio item table
	 */
	public function portfolioItem() {
		return $this->hasOne('Tricks\PortfolioItem', 'stock_code', 'code');
	}
	
	/**
	 * Relationship with Portfolio history item table
	 */
	public function portfolioHistroyItem() {
		return $this->hasOne('Tricks\PortfolioHistoryItem');
	}
	
    
	
	/**
	 * Relationship with Comment table
	 */
	public function comments() {
		return $this->morphMany('Tricks\Comment', 'commentable');
	}
	
	
	

}
