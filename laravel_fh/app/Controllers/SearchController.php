<?php

namespace Controllers;

use Illuminate\Support\Facades\Input;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\UserRepositoryInterface;

class SearchController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;
    
    /**
     * User repository.
     *
     * @var \Tricks\Repositories\UserRepositoryInterface
     */
    protected $users;

    /**
     * Create a new SearchController instance.
     *
     * @param  \Tricks\Repositories\TrickRepositoryInterface  $tricks
     * @return void
     */
    public function __construct(TrickRepositoryInterface $tricks, UserRepositoryInterface $users)
    {
        parent::__construct();

        $this->tricks = $tricks;
        $this->users = $users;
    }

    /**
     * Show the search results page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $term   = e(Input::get('q'));
        $tricks = null;

        if (! empty($term)) {
            $tricks = $this->tricks->searchByTermPaginated($term, 12);
        }

        $this->view('search.result', compact('tricks', 'term'));
    }
    
    /**
     * Show the search results page.
     *
     * @return \Response
     */
    public function getUserIndex()
    {
    	$term   = e(Input::get('q'));
    	$tricks = null;
    
    	if (! empty($term)) {
    		$users = $this->users->searchByTermPaginated($term, 12);
    	}
    
    	$this->view('admin.users.list', compact('users','term'));
    }
    
    
}
