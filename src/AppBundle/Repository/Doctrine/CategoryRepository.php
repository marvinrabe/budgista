<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Domain\BudgetId;
use AppBundle\Entity\Budget\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryRepository implements \AppBundle\Repository\CategoryRepository
{

    protected $em;

    public function __construct(EntityManagerInterface $em, BudgetId $budgetId)
    {
        $this->em = $em;
    }

    public function add(Category $category): void
    {
        $this->em->persist($category);
    }

    public function remove(Category $category): void
    {
        $this->em->remove($category);
    }

    public function exists($name): bool
    {

        $query = $this->em->createQuery('SELECT COUNT(c.id) FROM AppBundle\Entity\Budget\Category c WHERE c.name = ?1');
        $query->setParameter(1, $name);
        $count = $query->getSingleScalarResult();

        if ($count == 0) {
            return false;
        }
        return true;
    }

    public function findByName(string $name): Category
    {
        $query = $this->em->createQuery('SELECT c FROM AppBundle\Entity\Budget\Category c WHERE c.name = ?1');
        $query->setParameter(1, $name);

        /**
         * @var Category $category
         */
        return $query->getOneOrNullResult();
    }

    public function find(string $id): Category
    {
        $query = $this->em->createQuery('SELECT c FROM AppBundle\Entity\Budget\Category c WHERE c.id = ?1');
        $query->setParameter(1, $id);

        return $query->getOneOrNullResult();
    }

    /**
     * @return Category[]
     */
    public function findAll()
    {
        $query = $this->em->createQuery('SELECT c FROM AppBundle\Entity\Budget\Category c');

        return $query->getResult();
    }
}
