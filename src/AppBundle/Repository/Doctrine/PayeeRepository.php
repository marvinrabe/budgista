<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Payee;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class PayeeRepository implements \AppBundle\Repository\PayeeRepository
{

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function add(Payee $payee): void
    {
        $this->em->persist($payee);
    }

    public function remove(Payee $payee): void
    {
        $this->em->remove($payee);
    }

    public function findOrCreateByName(string $name): Payee
    {
        /**
         * @var Payee $payee
         */
        $query = $this->em->createQuery('SELECT p FROM AppBundle\Entity\Payee p WHERE p.name = ?1');
        $query->setParameter(1, $name);

        $payee = $query->getOneOrNullResult();

        if ($payee === null) {
            $payee = new Payee($name);
            $this->add($payee);
        }

        return $payee;
    }
}
