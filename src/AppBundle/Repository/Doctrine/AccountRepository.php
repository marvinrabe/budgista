<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Account;
use AppBundle\Exception\RepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class AccountRepository extends EntityRepository implements \AppBundle\Repository\AccountRepository
{

    public function add(Account $account): void
    {
        $this->_em->persist($account);
    }

    public function remove(Account $account): void
    {
        $this->_em->remove($account);
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
