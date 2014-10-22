<?php

namespace Controllers;

use Illuminate\Support\Facades\Input;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\UserRepositoryInterface;
use Tricks\Repositories\StockRepositoryInterface;
use Tricks\Repositories\PortfolioRepositoryInterface;

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
     * Stock repository.
     *
     * @var \Tricks\Repositories\StockRepositoryInterface
     */
    protected $stock;
    
    /**
     * Portfolio repository.
     *
     * @var \Tricks\Repositories\PortfolioRepositoryInterface
     */
    protected $portfolio;

    /**
     * Create a new SearchController instance.
     *
     * @param  \Tricks\Repositories\TrickRepositoryInterface  $tricks
     * @return void
     */
    public function __construct(TrickRepositoryInterface $tricks, 
    		UserRepositoryInterface $users, StockRepositoryInterface $stock,
    		PortfolioRepositoryInterface $portfolio)
    {
        parent::__construct();

        $this->tricks = $tricks;
        $this->users = $users;
        $this->stock = $stock;
        $this->portfolio = $portfolio;
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
    
    
    /**
     * Show the search results page.
     *
     * @return \Response
     */
    public function getStockIndex()
    {
    	$term   = e(Input::get('q'));
    	$stock = null;
    
    	if (! empty($term)) {
    		$stocks = $this->stock->searchByTermPaginated($term, 12);
    	}
    
    	$this->view('stocks.search', compact('stocks'));
    }
    
    /**
     * Show the search results page.
     *
     * @return \Response
     */
    public function getPortfolioIndex()
    {
    	$term   = e(Input::get('q'));
    	$portfolios = null;
    
    	if (! empty($term)) {
    		$portfolios = $this->portfolio->searchByTermPaginated($term, 12);
    	}
    
    	$this->view('portfolio.search', compact('portfolios'));
    }
    
}
