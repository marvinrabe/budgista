<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Budget\Account;
use Doctrine\ORM\EntityManagerInterface;

class AccountRepository implements \AppBundle\Domain\Repository\AccountRepository
{

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Account $account): void
    {
        $this->em->persist($account);
    }

    public function remove(Account $account): void
    {
        $this->em->remove($account);
    }

    public function exists(string $name): bool
    {
        $query = $this->em->createQuery('SELECT COUNT(a.id) FROM AppBundle\Entity\Budget\Account a WHERE a.name = ?1');
        $query->setParameter(1, $name);
        $count = $query->getSingleScalarResult();

        if ($count == 0) {
            return false;
        }
        return true;
    }

    public function find(string $id): Account
    {
        $query = $this->em->createQuery('SELECT a FROM AppBundle\Entity\Budget\Account a WHERE a.id = ?1');
        $query->setParameter(1, $id);

        return $query->getOneOrNullResult();
    }

    /**
     * @return Account[]
     */
    public function findAll(): array
    {
        $query = $this->em->createQuery('SELECT a FROM AppBundle\Entity\Budget\Account a');

        return $query->getResult();
    }
}
