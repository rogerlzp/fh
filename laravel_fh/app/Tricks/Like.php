<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'likes';
    
  //  protected $fillable = ['content', 'commentable_id', 'commentable_type', 'user_id'];


	
	/**
	 * Polymorphic relationship
	 */
	public function liketable() {
		return $this->morphTo();
	}
	
}
