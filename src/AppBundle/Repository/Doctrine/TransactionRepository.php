<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Transaction;
use AppBundle\Exception\RepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class TransactionRepository extends EntityRepository implements \AppBundle\Repository\TransactionRepository
{

    public function save(Transaction $transaction): void
    {
        $this->_em->getConnection()->beginTransaction();

        try {
            $this->_em->persist($transaction);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (ORMException $e) {
            throw new RepositoryException('Entity couldnt be added.');
        }
    }

    public function remove(Transaction $transaction): void
    {
        $this->_em->getConnection()->beginTransaction();

        try {
            $this->_em->remove($transaction);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (ORMException $e) {
            throw new RepositoryException('Entity couldnt be deleted.');
        }
    }

}