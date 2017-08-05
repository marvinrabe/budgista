<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Payee;
use AppBundle\Exception\RepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class PayeeRepository extends EntityRepository implements \AppBundle\Repository\PayeeRepository
{

    public function add(Payee $payee): void
    {
        $this->_em->persist($payee);
    }

    public function remove(Payee $payee): void
    {
        $this->_em->remove($payee);
    }

    public function findOrCreateByName(string $name): Payee
    {
        /**
         * @var Payee $payee
         */
        $payee = $this->findOneBy(['name' => $name]);
        if ($payee !== null) {
            return $payee;
        }

        $payee = new Payee($name);
        $this->add($payee);

        return $payee;
    }
}
