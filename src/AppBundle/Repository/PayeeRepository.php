<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Payee;

interface PayeeRepository
{

    public function add(Payee $payee): void;

    public function remove(Payee $payee): void;

    public function findOrCreateByName(string $name): Payee;

}
