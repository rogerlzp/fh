<?php

namespace Tricks\Repositories;

use Tricks\User;
use Tricks\PortfolioItem;

interface PortfolioItemRepositoryInterface
{
   
    /**
     * Find a portfolioItem by the given Id.
     *
     * @param  string $slug
     * @return \Tricks\PortfolioItem
     */
    public function findById($id);

    /**
     * Create a new portfolioItem in the database.
     *
     * @param  array $data
     * @return \Tricks\PortfolioItem
     */
    public function create(array $data);

    /**
     * Update the portfolioItem in the database.
     *
     * @param  \Tricks\PortfolioItem $portfolioItem
     * @param  array $data
     * @return \Tricks\PortfolioItem
     */
    public function edit(PortfolioItem $portfolioItem, array $data);


}
