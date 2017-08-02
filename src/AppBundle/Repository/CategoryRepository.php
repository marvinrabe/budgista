<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Category;

interface CategoryRepository
{

    public function save(Category $category): void;

    public function remove(Category $category): void;

    public function exists($name): bool;

    /**
     * @param string $name
     * @return Category
     */
    public function findByName($name);

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