<?php
# Route filters
Route::when('admin/*', 'admin');
Route::when('*', 'trick.view_throttle');

# Route patterns
Route::pattern('tag_slug', '[a-z0-9\-]+');
Route::pattern('trick_slug', '[a-z0-9\-]+');

# Admin routes
Route::group(['prefix'=>'admin', 'before'=>'auth', 'namespace' => 'Controllers\Admin' ], function () {
    Route::controller('tags', 'TagsController', [
        'getIndex' => 'admin.tags.index',
        'getView'  => 'admin.tags.view'
    ]);

    Route::controller('categories', 'CategoriesController', [
        'getIndex' => 'admin.categories.index',
        'getView'  => 'admin.categories.view'
    ]);
    
    
    Route::controller('product', 'ProductController', [
    'getIndex' => 'admin.product.index',
    'getView'  => 'admin.product.view'
    		]);
    
    
    Route::controller('category2', 'Category2Controller', [
    'getIndex' => 'admin.category2.index',
    'getView'  => 'admin.category2.view'
    		]);
    
    
    Route::controller('permission', 'PermissionController', [
    'getIndex' => 'admin.permission.index',
    'getView'  => 'admin.permission.view'
    		]);
    
    Route::controller('role', 'RoleController', [
    'getIndex' => 'admin.role.index',
    'getView'  => 'admin.role.view'
    		]);
    
  
    Route::controller('login', 'AdminController', [
    'getIndex' => 'admin.admin.index',
    'getView'  => 'admin.admin.view'
    		]);

    Route::get('category2',  ['as'=>'admin.category2.index', 'uses' => 'Category2Controller@getIndex']);
    
    Route::get('product',  ['as'=>'admin.product.create', 'uses' => 'ProductController@getCreate']);
    Route::post('product', 'ProductController@postCreate');
    
    
    Route::get('activity/create',  ['as'=>'admin.activity.create', 'uses' => 'ActivityController@getCreate']);
    Route::post('activity/create', 'ActivityController@postCreate');
    
    Route::get('activity/view/{id}',  ['as'=>'admin.activity.view', 'uses' => 'ActivityController@getView']);

    //Route::post('activity/view/{id}', 'ActivityController@postEdit');

    # Activity editing route
    Route::get('activity/{id}', [ 'as' => 'admin.activity.edit', 'uses' => 'ActivityController@getEdit' ]);
     Route::post('activity/{id}', 'ActivityController@postEdit');
    
     // Route::post('activity/update', ['as'=>'admin.activity.update', 'ActivityController@postUpdate']);
    
   // Route::get('/',  ['as'=>'admin.activity.index', 'uses' => 'ActivityController@getIndex']);
    
    Route::get('activity',  ['as'=>'admin.activity.index', 'uses' => 'ActivityController@getIndex']);
    Route::get('activitydetail',  ['as'=>'admin.activity.detail', 'uses' => 'ActivityController@getDetail']);
      
    Route::get('test5', [ 'as' => 'admin.show', 'uses' => 'AdminController@getIndex' ]);    
   //  Route::controller('users', 'UsersController');
   
    Route::get('users/create',  ['as'=>'admin.user.create', 'uses' => 'UsersController@getCreate']);
    Route::post('users/create', 'UsersController@postCreate');
    
    Route::get('users/index',  ['as'=>'admin.users.index', 'uses' => 'UsersController@getIndex']);
    Route::get('users/{id}',  ['as'=>'admin.users.view', 'uses' => 'UsersController@getView']);
    Route::post('users/{id}',  ['as'=>'admin.users.view', 'uses' => 'UsersController@postView']);
    

});

	Route::group(['namespace' => 'Controllers\Admin' ], function () {
		
		Route::get('test3/', [ 'as' => 'admin.login', 'uses' => 'AdminController@getLogin' ]);
	});



Route::group([ 'namespace' => 'Controllers' ], function () {
    # Home routes
    Route::get('browse/recent', [ 'as' => 'browse.recent', 'uses' => 'BrowseController@getBrowseRecent' ]);
    Route::get('popular', [ 'as' => 'browse.popular', 'uses' => 'BrowseController@getBrowsePopular' ]);
    Route::get('comments', [ 'as' => 'browse.comments', 'uses' => 'BrowseController@getBrowseComments' ]);
    Route::get('about', [ 'as' => 'about', 'uses' => 'HomeController@getAbout' ]);

    # Activity routes
    Route::get('activity/{activity_slug?}', [ 'as' => 'activity.show', 'uses' => 'ActivityController@getShow' ]);
    Route::post('activity/{activity_slug}/like', [ 'as' => 'activity.like', 'uses' => 'ActivityController@postLike' ]);

    # Browse routes
    Route::get('categories', [ 'as' => 'browse.categories', 'uses' => 'BrowseController@getCategoryIndex']);
    Route::get('categories/{category_slug}', [
        'as'   => 'activity.browse.category',
        'uses' => 'BrowseController@getBrowseCategory'
    ]);
    
    Route::get('tags', [ 'as' => 'browse.tags', 'uses' => 'BrowseController@getTagIndex' ]);
    Route::get('tags/{tag_slug}', [ 'as' => 'activity.browse.tag', 'uses' => 'BrowseController@getBrowseTag' ]);

    # Search routes
    Route::get('search', 'SearchController@getIndex');
    
    # Search routes
    Route::get('search/user', [ 'as' => 'search.users', 'uses' => 'SearchController@getUserIndex' ] );
    Route::get('search/stock', [ 'as' => 'search.stocks', 'uses' => 'SearchController@getStockIndex' ] );
    Route::get('search/portfolio', [ 'as' => 'search.portfolios', 'uses' => 'SearchController@getPortfolioIndex' ] );
    
    # Sitemap route
    Route::get('sitemap', 'SitemapController@getIndex');
    Route::get('sitemap.xml', 'SitemapController@getIndex');
    # Authentication and registration routes
    Route::get('login', [ 'as' => 'auth.login', 'uses' => 'AuthController@getLogin' ]);
    Route::post('login', 'AuthController@postLogin');
    
    Route::get('adminlogin', [ 'as' => 'auth.adminlogin', 'uses' => 'AuthController@getLogin' ]);
    Route::post('adminlogin', 'AuthController@postAdminLogin');
    
    Route::get('login/github', [ 'as' => 'auth.login.github', 'uses' => 'AuthController@getLoginWithGithub' ]);
    Route::get('register', [ 'as' => 'auth.register', 'uses' => 'AuthController@getRegister']);
    Route::post('register', 'AuthController@postRegister');
    Route::get('logout', [ 'as' => 'auth.logout', 'uses' => 'AuthController@getLogout' ]);

    # Password reminder routes
    Route::controller('password', 'RemindersController', [
        'getRemind' => 'auth.remind',
        'getReset'  => 'auth.reset'
    ]);

    # User profile routes
    Route::get('user', [ 'as' => 'user.index', 'uses' => 'UserController@getIndex' ]);
    Route::get('user/settings', [ 'as' => 'user.settings', 'uses' => 'UserController@getSettings' ]);
    Route::post('user/settings', 'UserController@postSettings');
    Route::get('user/favorites', [ 'as' => 'user.favorites', 'uses' => 'UserController@getFavorites' ]);
    Route::post('user/avatar', [ 'as' => 'user.avatar', 'uses' => 'UserController@postAvatar' ]);
    Route::get('user/image', [ 'as' => 'user.image', 'uses' => 'UserController@getImage' ]);
    Route::get('user/profile', [ 'as' => 'user.profile', 'uses' => 'UserController@getProfile' ]);


    # Feed routes
    Route::get('feed', [ 'as' => 'feed.atom', 'uses' => 'FeedsController@getAtom' ]);
    Route::get('feed.atom', [ 'uses' => 'FeedsController@getAtom' ]);
    Route::get('feed.xml', [ 'as' => 'feed.rss', 'uses' => 'FeedsController@getRss' ]);

    # This route will match the user by username to display their public profile
    # (if we want people to see who favorites and who posts what)
    Route::get('user/{user}', [ 'as' => 'user.profile', 'uses' => 'UserController@getPublic' ]);
   // Route::get('user/{id}', [ 'as' => 'user.profile', 'uses' => 'UserController@getPublic' ]);
    
    # Board creation route
    Route::get('user/board/new', [ 'as' => 'board.new', 'uses' => 'UserBoardController@getNew' ]);
    Route::post('user/board/new', ['as' => 'board.create', 'uses' => 'UserBoardController@postNew']);
    
    # Board show route
    Route::get('board/{id}', ['as' => 'board.show', 'uses' => 'BoardController@getShow']);
    
    # Board list route
    Route::get('user/board/list', ['as' => 'user.board', 'uses' => 'UserBoardController@getList' ]);
    
    # Board list route
    Route::get('user/board/list2', ['as' => 'user.board2', 'uses' => 'UserBoardController@getListByUserId' ]);
    
    
    # Image creation route
    Route::get('user/image/new_local', [ 'as' => 'image.new_local', 'uses' => 'UserImageController@getNewLocal' ]);
    Route::post('user/image/new_local', 'UserImageController@postNewLocal');
    
    # Image creation route
    Route::get('user/image/new_net', [ 'as' => 'image.new_net', 'uses' => 'UserImageController@getNewNet' ]);
    Route::post('user/image/new_net', 'UserImageController@postNewNet');
    
    # Image pin route
    Route::get('user/image/pin', [ 'as' => 'image.pin', 'uses' => 'UserImageController@postPin' ]);
    
    # Image list
    Route::get('image/show', [ 'as' => 'image.show', 'uses' => 'ImageController@getIndex' ]);

    # Image id
    Route::get('image/{id}', [ 'as' => 'image.single', 'uses' => 'ImageController@getSingle' ]);
 
    # Image upload route
 //   Route::get('user/files', ['as' => 'image.creation', 'uses' => 'ImageController@getUploadForm']);
    
    Route::post('image/upload', ['as' => 'image.upload', 'uses' => 'ImageController@postUpload']);

    
    # Add Comment route
   Route::post('user/comment', ['as' => 'user.comment', 'uses' => 'CommentController@postComment']);
   
   # Add Like route
   Route::post('user/like', ['as' => 'user.like', 'uses' => 'LikeController@postLike']);
   # Add DisLike route
   Route::post('user/dislike', ['as' => 'user.dislike', 'uses' => 'LikeController@postDislike']);
   
   # Follow  route
   Route::post('user/follow', ['as' => 'user.follow', 'uses' => 'UserController@postFollow']);
   # Unfollow route
   Route::post('user/unfollow', ['as' => 'user.unfollow', 'uses' => 'UserController@postUnfollow']);
    

   # Product list
   Route::get('product/show', [ 'as' => 'product.show', 'uses' => 'ProductController@getIndex' ]);
   
   # Product id
   Route::get('product/{id}', [ 'as' => 'product.single', 'uses' => 'ProductController@getSingle' ]);
    
   # Add Test route
   Route::get('user/test1', ['as' => 'user.test1', 'uses' => 'TestController@testComment']);
   Route::get('user/test2', ['as' => 'user.test1', 'uses' => 'TestController@testProductInfo']);
   Route::get('test/stock', ['as' => 'user.test1', 'uses' => 'TestController@stockInfo']);

   
   Route::get('user/tfollow1', ['as' => 'user.test_follow', 'uses' => 'TestController@testUserFollow']);
   
   
   
   # Home Route
   Route::get('home', [ 'as' => 'home.index', 'uses' => 'HomeController@getIndex' ]);
   Route::get('/', [ 'as' => 'home.index', 'uses' => 'HomeController@getIndex' ]);
   
  // Route::resource('api/v1', 'WeixinController');
   
   Route::get('api/v1', array(
   'as'     => 'wechat.test',
   'uses'   => 'WechatController@test',
   )); 
   
   

   # Stock list
   Route::get('stock/show', [ 'as' => 'stock.show', 'uses' => 'StockController@getIndex' ]);
    
   # Stock id
   Route::get('stock/{id}', [ 'as' => 'stock.single', 'uses' => 'StockController@getSingle' ]);
  
   # Stock list
   Route::post('add/stock', [ 'as' => 'stock.add', 'uses' => 'StockController@postAdd' ]);
   
   # Stock buy
   Route::post('stock/buy/{code}', [ 'as' => 'stock.buy', 'uses' => 'StockController@postBuy' ]);
   Route::get('stock/buy/{code}', [ 'as' => 'stock.buy', 'uses' => 'StockController@getBuy' ]);
    
    

   # Portfolio list
   Route::get('portfolio/myshow', [ 'as' => 'portfolio.myshow', 'uses' => 'PortfolioController@getProfileMyShow' ]);
   Route::get('portfolio/all', [ 'as' => 'portfolio.all', 'uses' => 'PortfolioController@getIndex' ]);
   Route::get('portfolio/create', [ 'as' => 'portfolio.create', 'uses' => 'PortfolioController@getCreate' ]);
   Route::post('portfolio/create', [ 'as' => 'portfolio.create', 'uses' => 'PortfolioController@postCreate' ]);

   Route::get('portfolio/pmyshow', [ 'as' => 'portfolio.profile_showmy', 'uses' => 'PortfolioController@getProfileMyShow' ]);
   Route::get('portfolio/show', [ 'as' => 'portfolio.profile_showbuy', 'uses' => 'PortfolioController@getProfileBuyShow' ]);
   Route::get('portfolio/show', [ 'as' => 'portfolio.profile_showwatch', 'uses' => 'PortfolioController@getProfileWatchShow' ]);
   
   // show single portfolio
   Route::get('portfolio/{id}', [ 'as' => 'portfolio.show_single', 'uses' => 'PortfolioController@getSingleShow' ]);
    
   # Create account
   Route::post('account/create', [ 'as' => 'account.create', 'uses' => 'PortfolioController@postCreateAccount' ]);
   
});




