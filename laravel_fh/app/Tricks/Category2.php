<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Category2 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category2';

    /**
     * Query the products that belong to the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function products()
	{
		return $this->belongsToMany('Tricks\Product');
	}
}
