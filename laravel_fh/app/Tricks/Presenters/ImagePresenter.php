<?php namespace Tricks\Presenters;

use Tricks\Image;
use McCool\LaravelAutoPresenter\BasePresenter;
use Illuminate\Support\Facades\Log;

class ImagePresenter extends BasePresenter {
	
	/**
	 * Cache for whether the user has liked this trick.
	 *
	 * @var bool
	 */
	protected $likedByUser = null;
	
	
	/**
	 * Cache for the image liked number
	 *
	 * @var bool
	 */
	protected $likedCounter = null;
	
	
	
	public function __construct(Image $image)
	{
		$this->resource = $image;
	}
	
	
	/**
	 * Returns whether the given user has liked this trick.
	 *
	 * @param  \Tricks\User $user
	 * @return bool
	 */
	public function likedByUser($user)
	{
		if (is_null($user)) {
			return false;
		}
	
		if (is_null($this->likedByUser)) {
			$this->likedByUser = $this->resource
			->likes()
			->where('user_id', $user->id)
			->exists();
		}
	
		return $this->likedByUser;
	}
	
	/**
	 * Returns whether the given user has liked this trick.
	 *
	 * @param  \Tricks\User $user
	 * @return bool
	 */
	public function likedCounter()
	{
		Log::info("likedCounter");
		if (is_null($this->likedCounter)) {
			if(count($this->resource->likes()->get()->first()) != 0) {
				$this->likedCounter = count($this->resource->likes()->get()->first());
			} else {
				$this->likedCounter = 0;
			}
			
		}
	
		return $this->likedCounter;
	}

	
	/**
	 * Get all the boards for this image.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Category[]
	 */
	public function allBoards()
	{
		return $this->resource->boards;
	}

}

