<?php

namespace Tricks\Repositories;

use Tricks\User;
use Tricks\Stock;

interface StockRepositoryInterface
{
   
    /**
     * Find a stock by the given code.
     *
     * @param  string $code
     * @return \Tricks\Stock
     */
    public function findByCode($code);

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
