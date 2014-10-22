<?php

namespace Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Tricks\Repositories\StockRepositoryInterface;
use Tricks\Repositories\PortfolioRepositoryInterface;
use Tricks\Repositories\PortfolioItemRepositoryInterface;

class StockController extends BaseController
{
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
     * PortfolioItem repository.
     *
     * @var \Tricks\Repositories\PortfolioItemRepositoryInterface
     */
    protected $portfolioItem;
    /**
     * Create a new StockController instance.
     *
     * @param \Tricks\Repositories\StockRepositoryInterface  $stock
     * @return void
     */
    public function __construct(StockRepositoryInterface $stock, 
    		PortfolioRepositoryInterface $portfolio, 
    		PortfolioItemRepositoryInterface $portfolioItem)
    {
        parent::__construct();

        $this->stock = $stock;
        $this->portfolio = $portfolio;
        $this->portfolioItem = $portfolioItem;
    }

    /**
     * list the most popular products when the user is not logged
     */
    
    public function getIndex() {
    	$stocks = $this->stock->findAllForUser(Auth::user());
    	Log::info("getIndex in ProductCOntroller");
    	Log::info($stocks);
    	return  $this->view('stocks.listall', compact('stocks'));
    }
    
    /**
     * Show the single trick page.
     *
     * @param  string $slugcartitem
     * @return \Response
     */
    public function getShow($slug = null)
    {
        if (is_null($slug)) {
            return $this->redirectRoute('home');
        }

        $stock = $this->stock->findBySlug($slug);

        if (is_null($$stock)) {
            return $this->redirectRoute('home');
        }

        Event::fire('stock.view', $stock);

        $this->view('stocks.single', compact('stock'));
    }

    /**
     * Handle the liking of a stock.
     *
     * @param  string $slug
     * @return \Response
     */
    public function postLike($slug)
    {
        if (! Request::ajax() || ! Auth::check()) {
            $this->redirectRoute('browse.recent');
        }

        $stock = $this->stock->findBySlug($slug);

        if (is_null($stock)) {
            return Response::make('error', 404);
        }

        $user = Auth::user();

        $voted = $stock->votes()->whereUserId($user->id)->first();

        if(!$voted) {

            $user = $stock->votes()->attach($user->id, [
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime
            ]);
            $stock->vote_cache = $stock->vote_cache + 1;

        } else {
            $stock->votes()->detach($voted->id);
            $stock->vote_cache = $stock->vote_cache - 1;
        }

        $stock->save();

        return Response::make($stock->vote_cache, 200);
    }
    
    
  
    
    /**
     * add stock
     */
    
    public function postAdd() {
    	$stockCode = Input::get('code');
    	$stock = $this->stock->findByCode($stockCode);
    	
    	Log::info("postAdd in ProductCOntroller");
    	Log::info($stock);
    	
    	$user = Auth::user();
    	
    	$user->stocks()->attach($stock);
    	
    	$stocks = $this->stock->findAllForUser(Auth::user());
    	
    	return  $this->view('stocks.listall', compact('stocks'));
    }
    

    /**
     * Show the single trick page.
     *
     * @param  string $slug
     * @return \Response
     */
    public function getBuy($code = null)
    {
    	$user = Auth::user();
    	$portfolioList = $this->portfolio->listAllByUser($user);
        Log::info($portfolioList);
    	
    	if (is_null($code)) {
    		return $this->redirectRoute('home');
    	}
    
    	$stock = $this->stock->findByCode($code);
    
    	if (is_null($stock)) {
    		return $this->redirectRoute('home');
    	}
    
    
    	$this->view('stocks.buy', compact('stock', 'portfolioList'));
    	
    }
    
    

    /**
     * buy stock
     * TODO: add transaction
     *
     * @param  string $slug
     * @return \Response
     */
    public function postBuy()
    {
    	$code = Input::get('code');
    
    	$stock = $this->stock->findByCode($code);
    
    	if (is_null($stock)) {
    		return $this->redirectRoute('home');
    	}
    	$data=[];
    	$data['user_id'] = Auth::user()->id;
    	$portfolioId = Input::get('portfolio');
        Log::info('portfolioId = '.$portfolioId);
        
        $operation = Input::get('operation');
        Log::info($operation);

    	$portfolio = $this->portfolio->findById($portfolioId);
    	$account = $portfolio->accounts()->first(); //TODO: get the account from different value

    	$price = floatval(Input::get('buy_price'));
    	$quantity = intval(Input::get('buy_quantity'));
    	
    	if (strcmp($operation, '1')) {
    		//sell
    		Log::info('get operation'.$operation);
    		
    		if ($portfolio->quantity > $quantity){  
    			// sell not owned 
    			// TODO: add error and return bakc
    			Log::info('not enough money');
    			Log::info($account->balance);
    			return $this->redirectBack();
    			
    		} else {
    			
    		}
    		
    		
    	} elseif (strcmp($operation, '0')) {
    		// buy
    		Log::info('get operation'.$operation);
    		if ($account->balance <  $price * $quantity){
    			Log::info('not enough money');
    			Log::info($account->balance);
    			return $this->redirectBack();
    		
    		} else {
    			$data1 = [];
    			$data1['portfolio_id'] = $portfolioId;
    			$data1['stock_code'] =  Input::get('code');
    			$data1['buy_price'] = Input::get('buy_price');
    			$data1['buy_quantity'] = Input::get('buy_quantity');
    			$portfolioItem = $this->portfolioItem->create($data1);
    			Log::info($portfolioItem);
    		
    		
    			//$portfolioItem->stock()->save($stock);
    			 
    			$portfolio->portfolioItems()->save($portfolioItem);
    			 
    			$portfolioItems = $portfolio->portfolioItems()->get();
    			 
    			$data2=[];
    			$account->balance =  $account->balance - $price * $quantity ;
    			$account->save();
    		
    			$accounts = $portfolio->accounts()->get();
    			 
    			$portfolioItems = $portfolio->portfolioItems()->get();
    			$this->view('user.profile2_myportfolio', compact('portfolio', 'portfolioItems', 'accounts'));
    		}
    		
    	}
    	if ($account->balance <  $price * $quantity){
    		Log::info('not enough money');
    		Log::info($account->balance);
    		return $this->redirectBack();
    		
    	} else {
    	$data1 = []; 
    	$data1['portfolio_id'] = $portfolioId;
    	$data1['stock_code'] =  Input::get('code');
    	$data1['buy_price'] = Input::get('buy_price');
    	$data1['buy_quantity'] = Input::get('buy_quantity');
    	$portfolioItem = $this->portfolioItem->create($data1);
    	Log::info($portfolioItem);


    	//$portfolioItem->stock()->save($stock);
    	
    	$portfolio->portfolioItems()->save($portfolioItem);
    	
    	$portfolioItems = $portfolio->portfolioItems()->get();
    	
    	$data2=[];
    	$account->balance =  $account->balance - $price * $quantity ;
    	$account->save();
    	    	
    	$accounts = $portfolio->accounts()->get();
    	
    	$portfolioItems = $portfolio->portfolioItems()->get();
    	$this->view('user.profile2_myportfolio', compact('portfolio', 'portfolioItems', 'accounts'));
    	}
    	
    //	$this->view('portfolio.listmy', compact('portfolio', 'portfolioItems'));
    	 
    }
    
}

