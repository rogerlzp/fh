<?php namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model {
	
	protected $table = "portfolio_item";
	
	
	
	public function stock()
	{
		return $this->belongsTo('Tricks\Stock', 'stock_code', 'code');
	}
	
	
	public function portfolio()
	{
		return $this->belongsTo('Tricks\Portfolio');
	}
	
}