<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Payee;

interface PayeeRepository
{

    public function save(Payee $payee): void;

    public function remove(Payee $payee): void;

    public function exists($name): bool;

    public function findByName($name): Payee;

}
