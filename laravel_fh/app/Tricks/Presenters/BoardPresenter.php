<?php namespace Tricks\Presenters;

use Tricks\Board;
use McCool\LaravelAutoPresenter\BasePresenter;

class BoardPresenter extends BasePresenter {
	
	public function __construct(Board $board)
	{
		$this->resource = $board;
	}
	
	/**
	 * Get all the boards for this image.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Category[]
	 */
	public function allImages()
	{
		return $this->resource->images;
	}
	
	
}

