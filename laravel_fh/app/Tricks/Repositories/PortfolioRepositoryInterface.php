<?php

namespace Tricks\Repositories;

use Tricks\User;
use Tricks\Portfolio;

interface PortfolioRepositoryInterface
{
   
    /**
     * Find a portfolio by the given slug.
     *
     * @param  string $slug
     * @return \Tricks\Portfolio
     */
    public function findBySlug($slug);

    /**
     * Create a new stock in the database.
     *
     * @param  array $data
     * @return \Tricks\Stock
     */
    public function create(array $data);

    /**
     * Update the portfolio in the database.
     *
     * @param  \Tricks\Portfolio $portfolio
     * @param  array $data
     * @return \Tricks\Portfolio
     */
    public function edit(Portfolio $portfolio, array $data);



}
