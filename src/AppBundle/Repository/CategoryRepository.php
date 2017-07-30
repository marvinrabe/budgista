<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Category;

interface CategoryRepository
{

    public function exists($name): bool;

    public function findByName($name): Category;

}