<?php

namespace AppBundle\Domain\Repository;

use AppBundle\Entity\Budget\Category;

interface CategoryRepository
{

    public function add(Category $category): void;

    public function remove(Category $category): void;

    public function exists($name): bool;

    public function findByName(string $name): Category;

    public function find(string $id): Category;

    /**
     * @return Category[]
     */
    public function findAll();

}
