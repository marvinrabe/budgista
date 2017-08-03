<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Budget;
use AppBundle\Exception\RepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class BudgetRepository extends EntityRepository implements \AppBundle\Repository\BudgetRepository
{

    public function save(Budget $budget): void
    {
        $this->_em->getConnection()->beginTransaction();

        try {
            $this->_em->persist($budget);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (ORMException $e) {
            throw new RepositoryException('Entity couldnt be added.');
        }
    }

    public function remove(Budget $budget): void
    {
        $this->_em->getConnection()->beginTransaction();

        try {
            $this->_em->remove($budget);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (ORMException $e) {
            throw new RepositoryException('Entity couldnt be deleted.');
        }
    }

}
