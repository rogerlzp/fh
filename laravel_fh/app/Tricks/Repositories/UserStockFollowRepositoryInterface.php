<?php

namespace Tricks\Repositories;

use Tricks\User;
use Tricks\UserStockFollow;

interface StockRepositoryInterface
{
   
    /**
     * Find a stock by the given slug.
     *
     * @param  string $slug
     * @return \Tricks\Stock
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
     * Update the stock in the database.
     *
     * @param  \Tricks\Stock $stock
     * @param  array $data
     * @return \Tricks\Stock
     */
    public function edit(Stock $stock, array $data);




}
