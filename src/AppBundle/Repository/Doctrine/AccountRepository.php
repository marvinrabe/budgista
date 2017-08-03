<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Account;
use AppBundle\Exception\RepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class AccountRepository extends EntityRepository implements \AppBundle\Repository\AccountRepository
{

    public function save(Account $account): void
    {
        $this->_em->getConnection()->beginTransaction();

        try {
            $this->_em->persist($account);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (ORMException $e) {
            throw new RepositoryException('Entity couldnt be added.');
        }
    }

    public function remove(Account $account): void
    {
        $this->_em->getConnection()->beginTransaction();

        try {
            $this->_em->remove($account);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (ORMException $e) {
            throw new RepositoryException('Entity couldnt be deleted.');
        }
    }

    public function exists($name): bool
    {
        /**
         * @var AccountRepository $account
         */
        $account = $this->findOneBy(['name' => $name]);

        if ($account === null) {
            return false;
        }
        return true;
    }
}