<?php

namespace Tricks\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Tricks\Repositories\UserRepositoryInterface',
            'Tricks\Repositories\Eloquent\UserRepository'
        );

        $this->app->bind(
            'Tricks\Repositories\ProfileRepositoryInterface',
            'Tricks\Repositories\Eloquent\ProfileRepository'
        );

        $this->app->bind(
            'Tricks\Repositories\TrickRepositoryInterface',
            'Tricks\Repositories\Eloquent\TrickRepository'
        );

        $this->app->bind(
            'Tricks\Repositories\TagRepositoryInterface',
            'Tricks\Repositories\Eloquent\TagRepository'
        );

        $this->app->bind(
            'Tricks\Repositories\CategoryRepositoryInterface',
            'Tricks\Repositories\Eloquent\CategoryRepository'
        );
        
        $this->app->bind(
        		'Tricks\Repositories\BoardRepositoryInterface',
        		'Tricks\Repositories\Eloquent\BoardRepository'
        );
        

        $this->app->bind(
        		'Tricks\Repositories\ImageRepositoryInterface',
        		'Tricks\Repositories\Eloquent\ImageRepository'
        );
        

        $this->app->bind(
        		'Tricks\Repositories\ImageBoardRepositoryInterface',
        		'Tricks\Repositories\Eloquent\ImageBoardRepository'
        );
        
        $this->app->bind(
        		'Tricks\Repositories\CommentRepositoryInterface',
        		'Tricks\Repositories\Eloquent\CommentRepository'
        );
        
        $this->app->bind(
        		'Tricks\Repositories\LikeRepositoryInterface',
        		'Tricks\Repositories\Eloquent\LikeRepository'
        );
        $this->app->bind(
        		'Tricks\Repositories\FollowRepositoryInterface',
        		'Tricks\Repositories\Eloquent\FollowRepository'
        );
        $this->app->bind(
        		'Tricks\Repositories\ProductRepositoryInterface',
        		'Tricks\Repositories\Eloquent\ProductRepository'
        );
        $this->app->bind(
        		'Tricks\Repositories\Category2RepositoryInterface',
        		'Tricks\Repositories\Eloquent\Category2Repository'
        );
        
        $this->app->bind(
        		'Tricks\Repositories\ProductPriceRepositoryInterface',
        		'Tricks\Repositories\Eloquent\ProductPriceRepository'
        );
        
        
        $this->app->bind(
        		'Tricks\Repositories\ActivityRepositoryInterface',
        		'Tricks\Repositories\Eloquent\ActivityRepository'
        );
        
        $this->app->bind(
        		'Tricks\Repositories\PermissionRepositoryInterface',
        		'Tricks\Repositories\Eloquent\PermissionRepository'
        );
        
        $this->app->bind(
        		'Tricks\Repositories\RoleRepositoryInterface',
        		'Tricks\Repositories\Eloquent\RoleRepository'
        );
        
        
        $this->app->bind(
        		'Tricks\Repositories\StockRepositoryInterface',
        		'Tricks\Repositories\Eloquent\StockRepository'
        );
        
        $this->app->bind(
        		'Tricks\Repositories\PortfolioRepositoryInterface',
        		'Tricks\Repositories\Eloquent\PortfolioRepository'
        );
        
        $this->app->bind(
        		'Tricks\Repositories\PortfolioItemRepositoryInterface',
        		'Tricks\Repositories\Eloquent\PortfolioItemRepository'
        );
        
        $this->app->bind(
        		'Tricks\Repositories\AccountRepositoryInterface',
        		'Tricks\Repositories\Eloquent\AccountRepository'
        );
    }
}
