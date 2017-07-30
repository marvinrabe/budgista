<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Payee;
use Doctrine\ORM\EntityRepository;

class PayeeRepository extends EntityRepository implements \AppBundle\Repository\PayeeRepository
{

    public function findByNameOrCreate($payee): Payee
    {
        // TODO: Implement findByNameOrCreate() method.
    }
}