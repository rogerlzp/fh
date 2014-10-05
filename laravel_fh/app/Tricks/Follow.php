<?php

namespace Tricks;

use Gravatar;
use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Reminders\RemindableInterface;

class Follow extends Model 
{
	/**
	 * The class to used to present the model.
	 *
	 * @var string
	 */
	// public $presenter = 'Tricks\Presenters\FollowsPresenter';

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'follows';
	
	
}