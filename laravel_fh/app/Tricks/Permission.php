<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';

	/**
	 * The class used to present the model.
	 *
	 * @var string
	 */
	public $presenter = 'Tricks\Presenters\PermissionPresenter';

	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
	//protected $with = [ 'tags', 'categories', 'user' ];


    /**
     * Many-to-Many relations with Roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
    	return $this->belongsToMany('Tricks\Role', 'permission_role');
    }

}
