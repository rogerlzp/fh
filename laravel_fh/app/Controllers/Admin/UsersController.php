<?php

namespace Controllers\Admin;

use Tricks\Repositories\UserRepositoryInterface;
use Tricks\Repositories\RoleRepositoryInterface;

class UsersController extends BaseController
{
    /**
     * User repository.
     *
     * @var \Tricks\Repositories\UserRepositoryInterface
     */
    protected $users;
    
    /**
     * Role repository.
     *
     * @var \Tricks\Repositories\RoleRepositoryInterface
     */
    protected $roles;

    /**
     * Create a new UsersController instance.
     *
     * @param  \Tricks\Repositories\UserRepositoryInterface $users
     * @return void
     */
    public function __construct(UserRepositoryInterface $users, RoleRepositoryInterface $roles )
    {
        parent::__construct();

        $this->users = $users;
        $this->roles = $roles;
    }

    /**
     * Show the users index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $users = $this->users->findAllPaginated();

        $this->view('admin.users.list', compact('users'));
    }
    
    
    /**
     * Show the user view page.
     *
     * @return \Response
     */
    public function getView($id)
    {
    	$user = $this->users->findById($id);
    	
    	$roles = $this->roles->listAll();
    	$selectedRoles = $this->users->listRolesForUser($user);
    	
    	$this->view('admin.users.edit', [
    			'roles'            => $roles,
    			'sroles'       => $selectedRoles,
    			'user'              => $user
    			]);
    	
    }
    
    /**
     * Handle the editing of a user.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postView($id)
    {
    	$form = $this->users->getForm();
    
    	if (! $form->isValid()) {
    		return $this->redirectRoute('admin.users.view', $id)
    		->withErrors($form->getErrors())
    		->withInput();
    	}
    	
    
    	$user = $this->users->update($id, $form->getInputData());
    
    	return $this->redirectRoute('admin.users.view', $id);
    }
    
    
}
