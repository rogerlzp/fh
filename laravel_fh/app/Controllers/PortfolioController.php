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
use Tricks\Repositories\AccountRepositoryInterface;
use Tricks\Repositories\PortfolioRepositoryInterface;
use Tricks\Repositories\PortfolioItemRepositoryInterface;

class PortfolioController extends BaseController
{
    
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
     * Account repository.
     *
     * @var \Tricks\Repositories\AccountRepositoryInterface
     */
    protected $account;
    
    /**
     * Create a new StockController instance.
     *
     * @param \Tricks\Repositories\StockRepositoryInterface  $stock
     * @return void
     */
    public function __construct(StockRepositoryInterface $stock, 
    		PortfolioRepositoryInterface $portfolio, 
    		PortfolioItemRepositoryInterface $portfolioItem,
			AccountRepositoryInterface $account)
    {
        parent::__construct();

        $this->stock = $stock;
        $this->portfolio = $portfolio;
        $this->portfolioItem = $portfolioItem;
        $this->account = $account;
    }

    /**
     * list the most popular products when the user is not logged
     */
    
    public function getIndex() {
    	$portfolios = $this->portfolio->listAll();
    
    	return  $this->view('portfolio.listall', compact('portfolios'));
    }
    
    /**
     * Show the single portfolio page.
     *
     * @param  string $id
     * @return \Response
     */
    public function getSingleShow($id = null)
    {
        if (is_null($id)) {
            return $this->redirectRoute('home');
        }

        $portfolio = $this->portfolio->findById($id);

        if (is_null($portfolio)) {
            return $this->redirectRoute('home');
        }

        Event::fire('portfolio.view', $portfolio);

        $this->view('portfolio.single', compact('portfolio'));
    }
    
    /**
     * Show my porfile page.
     *
     * @param  string $slugcartitem
     * @return \Response
     */
    public function getMyShow()
    {
    	Log::info("getMyShow");
    	
    	$portfolio = $this->portfolio->findForCurrentUser(Auth::user());  
    	if (is_null($portfolio)) {
    		return $this->redirectRoute('portfolio.create');
    	} else {
    	$portfolioItems = $portfolio->portfolioItems()->get();
    	$this->view('portfolio.listmy', compact('portfolio', 'portfolioItems'));
    	}
    }

    
    
    /**
     * Show my porfile page.
     *
     * @param  string $slugcartitem
     * @return \Response
     */
    public function getCreate()
    {
    	Log::info("create portfolio");
    	 
    	$this->view('portfolio.create');
    	
    	/*
    	$portfolio = $this->portfolio->findForCurrentUser(Auth::user());
    	if (is_null($portfolio)) {
    		return $this->redirectRoute('portfolio.create');
    	}
    
    	$portfolioItems = $portfolio->portfolioItems()->get();
    	$this->view('portfolio.listmy', compact('portfolio', 'portfolioItems'));
    	*/
    }
    
    
    /**
     * Show my porfile page.
     *
     * @param  string $slugcartitem
     * @return \Response
     */
    public function getProfileMyShow()
    {
    	$portfolio = $this->portfolio->findForCurrentUser(Auth::user());

    	if (is_null($portfolio)) {
    		$this->view('portfolio.create');
    	} else{
    	
    	
    	 $accounts = $portfolio->accounts()->get();
    	$portfolioItems = $portfolio->portfolioItems()->get();
    	$this->view('user.profile2_myportfolio', compact('portfolio', 'portfolioItems', 'accounts'));
    	}
    	
    	 
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
     * create portfolio
     */
    
    public function postCreate() {
    	
    	$data=[];
    	$data['user_id'] = Auth::user()->id;
    	$data['name'] = Input::get('name');
    	$data['slug'] = $data['name'];
    	$data['description']  = Input::get('description');
    	
    	$portfolio = $this->portfolio->create($data);
    	 

    	$accounts = $portfolio->accounts()->get();
    	$portfolioItems = $portfolio->portfolioItems()->get();
    	$this->view('user.profile2_myportfolio', compact('portfolio', 'portfolioItems', 'accounts'));

    }
    

    /**
     * Show the single trick page.
     *
     * @param  string $slug
     * @return \Response
     */
    public function getBuy($code = null)
    {
    	if (is_null($code)) {
    		return $this->redirectRoute('home');
    	}
    
    	$stock = $this->stock->findByCode($code);
    
    	if (is_null($stock)) {
    		return $this->redirectRoute('home');
    	}
    
    	Event::fire('stock.view', $stock);
    
    	$this->view('stocks.buy', compact('stock'));
    	
    }
    
    

    /**
     * Show the single portfolio page.
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
    	$data['name'] = Input::get('portfolio_name');
    	$data['slug'] = $data['name'];

    	$portfolio = $this->portfolio->create($data);
    	
    	$data1 = []; 
    	$data1['portfolio_id'] = $portfolio->id;
    	$data1['stock_code'] =  Input::get('code');
    	$data1['buy_price'] = Input::get('buy_price');
    	$data1['buy_quantity'] = Input::get('buy_quantity');
    	$portfolioItem = $this->portfolioItem->create($data1);
    	
    	$portfolio->portfolioItems()->save($portfolioItem);
    	$this->view('stocks.buy', compact('stock'));    	 
    }
    
    
    /**
     * create the account related to the portfolio
     *
     * @param  string $slug
     * @return \Response
     */
    public function postCreateAccount()
    {
    	$portfolioId = Input::get('portfolioId');
    	$portfolio = $this->portfolio->findById($portfolioId);

    	$data = [];
    	$data['original_balance'] = Input::get('original_balance');
    	$data['description'] = Input::get('description');
    	if(strcmp(Input::get('type'), 'USD')) {
    	$data['type'] = 0;}
    	elseif (strcmp(Input::get('type'), 'RMB')) {
    		$data['type'] = 1;
    	}
    	$data['portfolio_id'] = $portfolioId;
    	$account = $this->account->create($data);
    	$portfolio->accounts()->save($account);
    
    	
    	$accounts = $portfolio->accounts()->get();
    	$portfolioItems = $portfolio->portfolioItems()->get();
    	$this->view('user.profile2_myportfolio', compact('portfolio', 'portfolioItems', 'accounts'));
    	
    }   
}


