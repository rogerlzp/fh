<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

	/**
	 * The class used to present the model.
	 *
	 * @var string
	 */
	public $presenter = 'Tricks\Presenters\RolePresenter';

	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
	// protected $with = [  ];


	/**
	 * Query the user that posted the trick.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function users()
    {
        return $this->belongsToMany('Tricks\User', 'assigned_roles');
    }
    
 
    /**
     * Many-to-Many relations with Permission named perms as permissions is already taken.
     *
     * @return void
     */
    public function permissions()
    {

    	return $this->belongsToMany('Tricks\Permission', 'permission_role');
    	
    }
    


}
