<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Account;

interface AccountRepository
{

    public function exists($name): bool;

    public function find($id);

}