<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Budget\Account;

interface AccountRepository
{

    public function add(Account $account): void;

    public function remove(Account $account): void;

    public function exists(string $name): bool;

    public function find(string $id): Account;

    /**
     * @return Account[]
     */
    public function findAll();

}
