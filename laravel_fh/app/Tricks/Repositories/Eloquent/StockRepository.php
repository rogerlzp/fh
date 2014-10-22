<?php

namespace Tricks\Repositories\Eloquent;

use Disqus;
use Tricks\Tag;
use Tricks\User;
use Tricks\Stock;
use Tricks\Category;
use Illuminate\Support\Str;
use Tricks\Services\Forms\TrickForm;
use Tricks\Services\Forms\TrickEditForm;
use Tricks\Exceptions\TagNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Tricks\Exceptions\CategoryNotFoundException;
use Tricks\Repositories\StockRepositoryInterface;

class StockRepository extends AbstractRepository implements StockRepositoryInterface
{
    /**
     * Category model.
     *
     * @var \Tricks\Category
     */
    protected $category;

    /**
     * Tag model.
     *
     * @var \Tricks\Tag
     */
    protected $tag;

    /**
     * Create a new DbTrickRepository instance.
     *
     * @param  \Tricks\Trick  $trick
     * @param  \Tricks\Category  $category
     * @param  \Tricks\Tag  $tag
     * @return void
     */
    public function __construct(Stock $stock, Category $category, Tag $tag)
    {
        $this->model    = $stock;
        $this->category = $category;
        $this->tag      = $tag;
    }

    /**
     * Find all the stocks the user followed
     *
     * @param  \Tricks\User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Stock[]
     */
    public function findAllForUser(User $user, $perPage = 9)
    {
        $stocks = $user->stocks()->orderBy('created_at', 'DESC')->paginate($perPage);

        return $stocks;
    }

    /**
     * Find all stocks that are favorited by the given user paginated.
     *
     * @param  \Tricks\User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Stock[]
     */
    public function findAllFavorites(User $user, $perPage = 9)
    {
        $stocks = $user->votes()->orderBy('created_at', 'DESC')->paginate($perPage);

        return $stocks;
    }

    /**
     * Find a stock by the given code.
     *
     * @param  string $code
     * @return \Tricks\Stock
     */
    public function findByCode($code)
    {
        return $this->model->whereCode($code)->first();
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
     * Create a new trick in the database.
     *
     * @param  array $data
     * @return \Tricks\Trick
     */
    public function create(array $data)
    {
        $stock = $this->getNew();

        $stock->save();

        /*
        $trick->tags()->sync($data['tags']);
        $trick->categories()->sync($data['categories']);
        */

        return $stock;
    }

    /**
     * Update the trick in the database.
     *
     * @param  \Tricks\Stock $stock
     * @param  array $data
     * @return \Tricks\Stock
     */
    public function edit(Stock $stock, array $data)
    {
        //$trick->user_id = $data['user_id'];
        $trick->title       = e($data['title']);
        $trick->slug        = Str::slug($data['title'], '-');
        $trick->description = e($data['description']);
        $trick->code        = $data['code'];

        $stock->save();

        $trick->tags()->sync($data['tags']);
        $trick->categories()->sync($data['categories']);

        return $stock;
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
    

  
}
