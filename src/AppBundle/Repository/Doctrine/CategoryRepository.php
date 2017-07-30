<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository implements \AppBundle\Repository\CategoryRepository
{

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

    public function findByName($name): Category
    {
        /**
         * @var Category $category
         */
        $category = $this->findOneBy(['name' => $name]);

        if ($category === null) {
            throw new \Exception('Category "' . $name . '" not found.');
        }

        return $category;
    }

}