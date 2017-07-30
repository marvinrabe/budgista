<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Payee;

interface PayeeRepository
{

    public function exists($name): bool;

    public function findByName($name): Payee;

}