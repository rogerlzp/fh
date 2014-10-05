<?php

namespace Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Tricks\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ProductController extends BaseController
{
    /**
     * Product repository.
     *
     * @var \Tricks\Repositories\ProductRepositoryInterface
     */
    protected $products;

    /**
     * Create a new ProductController instance.
     *
     * @param \Tricks\Repositories\ProductRepositoryInterface  $products
     * @return void
     */
    public function __construct(ProductRepositoryInterface $products)
    {
        parent::__construct();

        $this->products = $products;
    }
    
    /**
     * list the most popular products when the user is not logged
     */
    
    public function getIndex() {
    	$products = $this->products->findAll(10);
		Log::info("getIndex in ProductCOntroller");
    	Log::info($products);
    	return  $this->view('product.all', compact('products'));
    }
    
    /**
     * list the most popular images when the use is not logged
     */
    
    public function getSingle($id) {
    
    	$product = $this->products->findById($id);
    	$comments = $product->comments;
    
    	return  $this->view('product.single_show', compact('product', 'comments'));
    }
    
    
    /**
     * Show the single product page.
     *
     * @param  string $slug
     * @return \Response
     */
    public function getShow($slug = null)
    {/*
        if (is_null($slug)) {
            return $this->redirectRoute('home');
        }

        $trick = $this->tricks->findBySlug($slug);

        if (is_null($trick)) {
            return $this->redirectRoute('home');
        }

        Event::fire('trick.view', $trick);

        $next = $this->tricks->findNextTrick($trick);
        $prev = $this->tricks->findPreviousTrick($trick);

        $this->view('tricks.single', compact('trick', 'next', 'prev'));
        */
    }

    /**
     * Handle the liking of a trick.
     *
     * @param  string $slug
     * @return \Response
     */
    public function postLike($slug)
    {
        if (! Request::ajax() || ! Auth::check()) {
            $this->redirectRoute('browse.recent');
        }

        $trick = $this->tricks->findBySlug($slug);

        if (is_null($trick)) {
            return Response::make('error', 404);
        }

        $user = Auth::user();

        $voted = $trick->votes()->whereUserId($user->id)->first();

        if(!$voted) {

            $user = $trick->votes()->attach($user->id, [
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime
            ]);
            $trick->vote_cache = $trick->vote_cache + 1;

        } else {
            $trick->votes()->detach($voted->id);
            $trick->vote_cache = $trick->vote_cache - 1;
        }

        $trick->save();

        return Response::make($trick->vote_cache, 200);
    }
}
