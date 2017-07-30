<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Payee;

interface PayeeRepository
{

    public function findByNameOrCreate($payee): Payee;

}