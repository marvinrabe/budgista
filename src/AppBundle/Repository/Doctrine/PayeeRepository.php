<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Payee;
use Doctrine\ORM\EntityRepository;

class PayeeRepository extends EntityRepository implements \AppBundle\Repository\PayeeRepository
{

    public function exists($name): bool
    {
        /**
         * @var Payee $payee
         */
        $payee = $this->findOneBy(['name' => $name]);

        if ($payee === null) {
            return false;
        }
        return true;
    }

    public function findByName($name): Payee
    {
        /**
         * @var Payee $payee
         */
        $payee = $this->findOneBy(['name' => $name]);

        if ($payee === null) {
            throw new \Exception('Payee "' . $name . '" not found.');
        }

        return $payee;
    }

}