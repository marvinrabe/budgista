<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Budget;

interface BudgetRepository
{
    public function create($name): Budget;

    public function delete(Budget $budget): void;

    public function findAll(): array;

    public function findByName($name): Budget;

}