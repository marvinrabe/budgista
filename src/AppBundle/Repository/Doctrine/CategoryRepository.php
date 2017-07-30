<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository implements \AppBundle\Repository\CategoryRepository
{

    public function findByName($category): Category
    {
        // TODO: Implement findByName() method.
    }

}