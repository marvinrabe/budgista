<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Category;

interface CategoryRepository
{

    public function findByName($category): Category;

}