<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'productprice';

	/**
	 * The class used to present the model.
	 *
	 * @var string
	 */


	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
	// protected $with = [ 'tags', 'categories', 'user' ];

	
	/**
	 * Query the image that belongs to the product.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */

	

	public function product()
	{
		return $this->belongsTo('Tricks\Product');
	}
	
	/**
	 * Relationship with Comment table
	 */
	public function comments() {
		return $this->morphMany('Tricks\Comment', 'commentable');
	}
	
	
	

}
