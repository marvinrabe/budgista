<?php

namespace AppBundle\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;

class AccountRepository extends EntityRepository implements \AppBundle\Repository\AccountRepository
{

    public function exists($name): bool
    {
        return false; // TODO
    }

}