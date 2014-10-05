<?php

namespace Tricks\Repositories\Eloquent;

use Disqus;
use Tricks\Tag;
use Tricks\User;
use Tricks\Product;
use Tricks\Category2;
use Illuminate\Support\Str;
use Tricks\Services\Forms\ProductForm;
use Tricks\Services\Forms\ProductEditForm;
use Tricks\Exceptions\TagNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Tricks\Exceptions\CategoryNotFoundException;
use Tricks\Repositories\ProductRepositoryInterface;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    /**
     * Category model.
     *
     * @var \Tricks\Category2
     */
    protected $category2;

    /**
     * Tag model.
     *
     * @var \Tricks\Tag
     */
    protected $tag;

    /**
     * Create a new ProductRepository instance.
     *
     * @param  \Tricks\Product  $product
     * @param  \Tricks\Category2  $category2
     * @param  \Tricks\Tag  $tag
     * @return void
     */
    public function __construct(Product $product, Category2 $category2, Tag $tag)
    {
        $this->model    = $product;
        $this->category2 = $category2;
        $this->tag      = $tag;
    }

    

    /**
     * Find a product by the given slug.
     *
     * @param  string $slug
     * @return \Tricks\Trick
     */
    public function findBySlug($slug)
    {
        return $this->model->whereSlug($slug)->first();
    }

    /**
     * Find all the products paginated.
     *
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Product[]
     */
    public function findAllPaginated($perPage = 9)
    {
        $products = $this->model->orderBy('created_at', 'DESC')->paginate($perPage);

        return $products;
    }

    /**
     * Find all tricks order by the creation date paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findMostRecent($per_page = 9)
    {
        return $this->findAllPaginated($per_page);
    }

    /**
     * Find the tricks ordered by the number of comments paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findMostCommented($perPage = 9)
    {
        $tricks = $this->model->orderBy('created_at', 'desc')->get();

        $tricks = Disqus::appendCommentCounts($tricks);

        $tricks = $tricks->sortBy(function ($trick) {
            return $trick->comment_count;
        })->reverse();

        $page = \Input::get('page', 1);
        $skip = ($page - 1) * $perPage;
        $items = $tricks->all();
        array_splice($items, 0, $skip);

        return \Paginator::make($items, count($tricks), $perPage);
    }

    /**
     * Find the tricks ordered by popularity (most liked / viewed) paginated.
     *
     * @param  integer  $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findMostPopular($per_page = 9)
    {
        return $this->model
                    ->orderByRaw('(tricks.vote_cache * 5 + tricks.view_cache) DESC')
                    ->paginate($per_page);
    }

    /**
     * Find the last 15 tricks that were added.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Trick[]
     */
    public function findForFeed()
    {
        return $this->model->orderBy('created_at', 'desc')->limit(15)->get();
    }

    /**
     * Find all tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Trick[]
     */
    public function findAllForSitemap()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    /**
     * Find all tricks for the category that matches the given slug.
     *
     * @param  string $slug
     * @param  integer $perPage
     * @return array
     */
    public function findByCategory($slug, $perPage = 9)
    {
        $category = $this->category2->whereSlug($slug)->first();

        if (is_null($category)) {
            throw new CategoryNotFoundException('The category "'.$slug.'" does not exist!');
        }

        $products = $category->products()->orderBy('created_at', 'DESC')->paginate($perPage);

        return [ $category, $products ];
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
        $tricks =  $this->model
                        ->orWhere('title', 'LIKE', '%'.$term.'%')
                        ->orWhere('description', 'LIKE', '%'.$term.'%')
                        ->orWhereHas('tags', function ($query) use ($term) {
                            $query->where('title', 'LIKE', '%' . $term . '%')
                                  ->orWhere('slug', 'LIKE', '%' . $term . '%');
                        })
                        ->orWhereHas('categories', function ($query) use ($term) {
                            $query->where('name', 'LIKE', '%' . $term . '%')
                                  ->orWhere('slug', 'LIKE', '%' . $term . '%');
                        })
                        ->orderBy('created_at', 'desc')
                        ->orderBy('title', 'asc')
                        ->paginate($perPage);

        return $tricks;
    }

    /**
     * Get a list of tag ids that are associated with the given trick.
     *
     * @param  \Tricks\Trick $trick
     * @return array
     */
    public function listTagsIdsForTrick(Trick $trick)
    {
    //    return $trick->tags->lists('id');
    }

    /**
     * Get a list of category ids that are associated with the given trick.
     *
     * @param  \Tricks\Trick $trick
     * @return array
     */
    public function listCategoriesIdsForProduct(Product $product)
    {
       // return $product->categories->lists('id');
    }

    /**
     * Create a new trick in the database.
     *
     * @param  array $data
     * @return \Tricks\Trick
     */
    public function create(array $data)
    {
        $product = $this->getNew();

        $product->user_id     = $data['user_id'];
        $product->name       = e($data['name']);
        $product->slug        = Str::slug($data['name'], '-');
        $product->short_description = e($data['short_description']);
        $product->sku       = e($data['sku']);
        $product->image_id       = e($data['image_id']);


        $product->save();

     //   $product->tags()->sync($data['tags']);
    //    $product->categories()->sync($data['categories']);

        return $product;
    }

    /**
     * Update the trick in the database.
     *
     * @param  \Tricks\Trick $trick
     * @param  array $data
     * @return \Tricks\Trick
     */
    public function edit(Product $product, array $data)
    {
        //$trick->user_id = $data['user_id'];
        $product->title       = e($data['title']);
        $product->slug        = Str::slug($data['title'], '-');
        $product->description = e($data['description']);
    

        $product->save();

      //  $product->tags()->sync($data['tags']);
      //  $product->categories()->sync($data['categories']);

        return $product;
    }

    /**
     * Increment the view count on the given trick.
     *
     * @param  \Tricks\Trick $trick
     * @return \Tricks\Trick
     */
    public function incrementViews(Product $product)
    {
        $product->view_cache = $product->view_cache + 1;
        $product->save();

        return $product;
    }

    /**
     * Find all tricks for the tag that matches the given slug.
     *
     * @param  string $slug
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function findByTag($slug, $perPage = 9)
    {
        $tag = $this->tag->whereSlug($slug)->first();

        if (is_null($tag)) {
            throw new TagNotFoundException('The tag "' . $slug . '" does not exist!');
        }

        $tricks = $tag->tricks()->orderBy('created_at', 'desc')->paginate($perPage);

        return [ $tag, $tricks ];
    }

    /**
     * Find the next trick that was added after the given trick.
     *
     * @param  \Tricks\Trick  $trick
     * @return \Tricks\Trick|null
     */
    /*
    public function findNextTrick(Trick $trick)
    {
        $next = $this->model->where('created_at', '>=', $trick->created_at)
                            ->where('id', '<>', $trick->id)
                            ->orderBy('created_at', 'asc')
                            ->first([ 'slug', 'title' ]);

        return $next;
    }
    */

    /**
     * Find the previous trick added before the given trick.
     *
     * @param  \Tricks\Trick  $trick
     * @return \Tricks\Trick|null
     */
    /*
    public function findPreviousTrick(Trick $trick)
    {
        $prev = $this->model->where('created_at', '<=', $trick->created_at)
                            ->where('id', '<>', $trick->id)
                            ->orderBy('created_at', 'desc')
                            ->first([ 'slug', 'title' ]);

        return $prev;
    }
 */
    /**
     * Check if the user owns the trick corresponding to the given slug.
     *
     * @param  string  $slug
     * @param  mixed   $userId
     * @return bool
     */
    public function isTrickOwnedByUser($slug, $userId)
    {
        return $this->model->whereSlug($slug)->whereUserId($userId)->exists();
    }

    /**
     * Get the product creation form service.
     *
     * @return \Tricks\Services\Forms\ProductForm
     */
    public function getCreationForm()
    {
        return new ProductForm;
    }

    /**
     * Get the trick edit form service.
     *
     * @return \Tricks\Services\Forms\TrickEditForm
     */
    public function getEditForm($id)
    {
        return new ProductEditForm($id);
    }
    
    /**
     * Find the product information
     *
     * @param  \Tricks\User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\image
     */
    public function findById($id)
    {
    	$product = $this->model->whereId($id)->first();
    
    	return $product;
    }
    
    
    /**
     * Find all the images for the given user paginated.
     *
     * @param  \Tricks\User $user
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\image[]
     */
    public function findAll($perPage = 9)
    {

    	$products = $this->model->all();

    	return $products;
    }
}
