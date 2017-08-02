<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Account;

interface AccountRepository
{

    public function save(Account $account): void;

    public function remove(Account $account): void;

    public function exists($name): bool;

    /**
     * @param string $id
     * @return Account
     */
    public function find($id);

    /**
     * @return Account[]
     */
    public function findAll();

}