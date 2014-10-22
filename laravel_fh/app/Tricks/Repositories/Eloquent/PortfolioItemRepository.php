<?php

namespace Tricks\Repositories\Eloquent;

use Disqus;
use Tricks\Tag;
use Tricks\User;
use Tricks\Stock;
use Tricks\Portfolio;
use Tricks\PortfolioItem;
use Tricks\Category;
use Illuminate\Support\Str;
use Tricks\Services\Forms\TrickForm;
use Tricks\Services\Forms\TrickEditForm;
use Tricks\Exceptions\TagNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Tricks\Exceptions\CategoryNotFoundException;
use Tricks\Repositories\StockRepositoryInterface;
use Tricks\Repositories\PortfolioItemRepositoryInterface;

class PortfolioItemRepository extends AbstractRepository implements PortfolioItemRepositoryInterface
{
    /**
     * PortfolioItem model.
     *
     * @var \Tricks\PortfolioItem
     */
    protected $portfolioItem;

    /**
     * Tag model.
     *
     * @var \Tricks\Tag
     */
    protected $tag;
    
    /**
     * Stock model.
     *
     * @var \Tricks\Stock
     */
    protected $stock;
    
    /**
     * Portfolio model.
     *
     * @var \Tricks\Portfolio
     */
    protected $portfolio;

    /**
     * Create a new DbTrickRepository instance.
     *
     * @param  \Tricks\Trick  $trick
     * @param  \Tricks\Category  $category
     * @param  \Tricks\Tag  $tag
     * @return void
     */
    public function __construct(Stock $stock, PortfolioItem $portfolioItem, 
    		Tag $tag, Portfolio $portfolio)
    {
        $this->model    = $portfolioItem;
        $this->portfolio = $portfolio;
        $this->tag      = $tag;
        $this->stock  = $stock;
    }

    /**
     * Find all the portfolio the user followed
     *
     * @param  \Tricks\User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tri$stockcks\Portfolio[]
     */
    public function findAllForUser(User $user, $perPage = 9)
    {
        $portfolios = $user->portfolios()->orderBy('created_at', 'DESC')->paginate($perPage);

        return $portfolios;
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
     * @return \Tricks\Portfolio<?php


    /**
     * Create a new portfolioItem in the database.
     *
     * @param  array $data
     * @return \Tricks\PortfolioItem
     */
    public function create(array $data)
    {
        $portfolioItem = $this->getNew();
        $portfolioItem->portfolio_id = $data['portfolio_id'];
        $portfolioItem->stock_code = $data['stock_code'];
        $portfolioItem->buy_price = $data['buy_price'];
        $portfolioItem->buy_quantity = $data['buy_quantity'];

        $portfolioItem->save();   

        
        return $portfolioItem;
    }

   



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
     * Update the portfolioItem in the database.
     *
     * @param  \Tricks\PortfolioItem $portfolioItem
     * @param  array $data
     * @return \Tricks\PortfolioItem
     */
    public function edit(PortfolioItem $portfolioItem, array $data)
    {
        //$trick->user_id = $data['user_id'];
        $portfolioItem->title       = e($data['title']);
        $portfolioItem->slug        = Str::slug($data['title'], '-');
        $portfolioItem->description = e($data['description']);
        $portfolioItem->code        = $data['code'];

        $portfolioItem->save();

        $portfolioItem->tags()->sync($data['tags']);
        $portfolioItem->categories()->sync($data['categories']);

        return $portfolioItem;
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
     * Find all portfolio that are favorited by the given user paginated.
     *
     * @param  \Tricks\User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Portfolio[]
     */
    public function mystock()
    {
    	$stock = $this->model->stock()->get();
    
    	return $stock;
    }
  
}
