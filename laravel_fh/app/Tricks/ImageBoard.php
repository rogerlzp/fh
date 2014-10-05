<?php namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class ImageBoard extends Model {
	
	protected $table = "image_board";
	
	// public $presenter  = "Tricks\Presenters\ImageBoardPresenter";
	
	/**
	 * 
	 */
	public function user()
	{
		return $this->belongsTo('Tricks\User');
	}
	
	
	
	
}