<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Category;
use AppBundle\Exception\RepositoryException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class CategoryRepository extends EntityRepository implements \AppBundle\Repository\CategoryRepository
{

    public function save(Category $category): void
    {
        $this->_em->getConnection()->beginTransaction();

        try {
            $this->_em->persist($category);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (ORMException $e) {
            throw new RepositoryException('Entity couldnt be added.');
        }
    }

    public function remove(Category $category): void
    {
        $this->_em->getConnection()->beginTransaction();

        try {
            $this->_em->remove($category);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        } catch (ORMException $e) {
            throw new RepositoryException('Entity couldnt be deleted.');
        }
    }

    public function exists($name): bool
    {
        /**
         * @var Category $category
         */
        $category = $this->findOneBy(['name' => $name]);

        if ($category === null) {
            return false;
        }
        return true;
    }

    public function findByName(string $name): Category
    {
        /**
         * @var Category $category
         */
        $category = $this->findOneBy(['name' => $name]);

        if ($category === null) {
            throw new RepositoryException('Category "' . $name . '" not found.');
        }

        return $category;
    }

}
