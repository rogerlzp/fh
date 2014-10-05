<?php

namespace Tricks\Repositories;

use Tricks\User;
use Tricks\ProductPrice;

interface ProductPriceRepositoryInterface
{
   
    /**
     * Create a new trick in the database.
     *
     * @param  array $data
     * @return \Tricks\Trick
     */
    public function create(array $data);

    /**
     * Update the trick in the database.
     *
     * @param  \Tricks\Trick $trick
     * @param  array $data
     * @return \Tricks\Trick
     */
   // public function edit(Trick $trick, array $data);

    
}
