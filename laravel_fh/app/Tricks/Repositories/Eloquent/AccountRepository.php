<?php

namespace Tricks\Repositories\Eloquent;

use Disqus;
use Tricks\Tag;
use Tricks\User;
use Tricks\Account;
use Tricks\Portfolio;
use Tricks\Category;
use Illuminate\Support\Str;
use Tricks\Services\Forms\TrickForm;
use Tricks\Services\Forms\TrickEditForm;
use Tricks\Exceptions\TagNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Tricks\Exceptions\CategoryNotFoundException;
use Tricks\Repositories\AccountRepositoryInterface;
use Tricks\Repositories\PortfolioRepositoryInterface;
use Illuminate\Support\Facades\Log;

class AccountRepository extends AbstractRepository implements AccountRepositoryInterface
{
   
    /**
     * Account model.
     *
     * @var \Tricks\Account
     */
    protected $account;
    
    /**
     * Portfolio model.
     *
     * @var \Tricks\Portfolio
     */
    protected $portfolio;

    /**
     * Create a new AccountRepository instance.
     *
     * @param  \Tricks\Trick  $trick
     * @param  \Tricks\Category  $category
     * @param  \Tricks\Tag  $tag
     * @return void
     */
    public function __construct(Account $account, Category $category, 
    		Tag $tag, Portfolio $portfolio)
    {
        $this->model    = $account;
        $this->category = $category;
        $this->tag      = $tag;
        $this->portfolio  = $portfolio;
    }

    /**
     * Find all the portfolio the user followed
     *
     * @param  \Tricks\User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tri$stockcks\Portfolio[]
     */
    public function findForCurrentUser(User $user)
    {
        $portfolio = $user->myportfolio()->first();
        Log::info($portfolio);
        
        $portfolioItem = $portfolio->portfolioItems()->first();
        Log::info($portfolioItem);

        return $portfolio;
    }

    /**
     * Find all portfolio that are favorited by the given user paginated.
     *
     * @param  \Tricks\User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Portfolio[]
     */
    public function findAllFavorites(User $user, $perPage = 9)
    {
        $portfolios = $user->portfolios()->orderBy('created_at', 'DESC')->paginate($perPage);

        return $portfolios;
    }

    /**
     * Find a portfolio by the given code.
     *
     * @param  string $slug
     * @return \Tricks\Portfolio
     */
    public function findBySlug($slug)
    {
        return $this->model->whereSlug($slug)->first();
    }


    /**
     * Find an account by the id.
     *
     * @param  string $slug
     * @return \Tricks\Portfolio
     */
    public function findById($id)
    {
    	return $this->model->whereId($id)->first();
    }
    

  

    /**
     * Find the stocks ordered by popularity (most liked / viewed) paginated.
     *
     * @param  integer  $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Stock[]
     */
    public function findMostPopular($per_page = 9)
    {
        return $this->model
                    ->orderByRaw('(stocks.vote_cache * 5 + stocks.view_cache) DESC')
                    ->paginate($per_page);
    }

    /**
     * Find the last 15 stockes that were added.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Trick[]
     */
    public function findForFeed()
    {
        return $this->model->orderBy('created_at', 'desc')->limit(15)->get();
    }

    

    
    /**
     * Find all tricks that match the given search term.
     *
     * @param  string $term
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function searchByTermPaginated($term, $perPage = 12)
    {
        $stocks =  $this->model
                        ->orWhere('code', 'LIKE', '%'.$term.'%')
                        ->orWhere('name', 'LIKE', '%'.$term.'%')
                        ->paginate($perPage);

        return $stocks;
    }

    /**
     * Get a list of tag ids that are associated with the given trick.
     *
     * @param  \Tricks\Trick $trick
     * @return array
     */
    public function listTagsIdsForTrick(Trick $trick)
    {
        return $trick->tags->lists('id');
    }

    /**
     * Get a list of category ids that are associated with the given trick.
     *
     * @param  \Tricks\Trick $trick
     * @return array
     */
    public function listCategoriesIdsForTrick(Trick $trick)
    {
        return $trick->categories->lists('id');
    }

    /**
     * Create a new account in the database.
     *
     * @param  array $data
     * @return \Tricks\Portfolio
     */
    public function create(array $data)
    {
        $account = $this->getNew();
        $account->original_balance = $data['original_balance'];
        $account->balance = $data['original_balance'];
        $account->description = $data['description'] ;
        $account->type =  $data['type'];
        $account->portfolio_id =  $data['portfolio_id'];
      
        $account->save();
        return $account;
    }

    /**
     * Update the account in the database.
     *
     * @param  \Tricks\Account $account
     * @param  array $data
     * @return \Tricks\Account
     */
    public function edit(Account $account, array $data)
    {
        $account->balance = $data['balance'];
        $account->save();
        return $account;
    }

    /**
     * Increment the view count on the given trick.
     *
     * @param  \Tricks\Stock $stock
     * @return \Tricks\Stock
     */
    public function incrementViews(Stock $stock)
    {
        $stock->view_cache = $stock->view_cache + 1;
        $stock->save();

        return $stock;
    }


    /**
     * Get the stock creation form service.
     *
     * @return \Tricks\Services\Forms\StockForm
     */
    public function getCreationForm()
    {
        return new TrickForm;
    }
    
    
    /**
     * Get an array of key-value paris of all portfolios
     *
     * @return Array
     */
    public function listAll() {
    	$portfolios = $this->model->lists('name', 'id');
    	return $portfolios;
    }
    

  
}
