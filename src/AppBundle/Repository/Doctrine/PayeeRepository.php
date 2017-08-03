<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Payee;
use AppBundle\Exception\RepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class PayeeRepository extends EntityRepository implements \AppBundle\Repository\PayeeRepository
{

    public function save(Payee $payee): void
    {
        $this->_em->getConnection()->beginTransaction();

        try {
            $this->_em->persist($payee);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (ORMException $e) {
            throw new RepositoryException('Entity couldnt be added.');
        }
    }

    public function remove(Payee $payee): void
    {
        $this->_em->getConnection()->beginTransaction();

        try {
            $this->_em->remove($payee);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (ORMException $e) {
            throw new RepositoryException('Entity couldnt be deleted.');
        }
    }

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
