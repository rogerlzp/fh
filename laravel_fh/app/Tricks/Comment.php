<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment';
    
  //  protected $fillable = ['content', 'commentable_id', 'commentable_type', 'user_id'];

    /**
     * Query the tricks that belong to the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	
	/**
	 * Polymorphic relationship
	 */
	public function commentable() {
		return $this->morphTo();
	}
	
}
