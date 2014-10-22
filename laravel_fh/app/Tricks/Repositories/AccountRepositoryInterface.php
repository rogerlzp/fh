<?php

namespace Tricks\Repositories;

use Tricks\User;
use Tricks\Account;

interface AccountRepositoryInterface
{
   
    /**
     * Find a account by the given id.
     *
     * @param  string $id
     * @return \Tricks\Portfolio
     */
    public function findById($id);

    /**
     * Create a new account in the database.
     *
     * @param  array $data
     * @return \Tricks\Account
     */
    public function create(array $data);

    /**
     * Update the account in the database.
     *
     * @param  \Tricks\Account $account
     * @param  array $data
     * @return \Tricks\Account
     */
    public function edit(Account $account, array $data);



}
