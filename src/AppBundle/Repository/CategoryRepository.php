<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;

interface CategoryRepository
{

    public function add(Category $category): void;

    public function remove(Category $category): void;

    public function exists($name): bool;

    public function findByName(string $name): Category;

    /**
     * @param string $id
     * @return Category
     */
    public function find($id);

    /**
     * @return Category[]
     */
    public function findAll();


}
