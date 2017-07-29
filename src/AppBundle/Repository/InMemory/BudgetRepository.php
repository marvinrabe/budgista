<?php

namespace AppBundle\Repository\InMemory;

use AppBundle\Entity\Budget;
use AppBundle\Exception\NotFoundException;

class BudgetRepository implements \AppBundle\Repository\BudgetRepository
{
    private $repository = [];

    public function create($name): Budget
    {
        $budget = new Budget($name);
        $this->repository[] = $budget;
        return $budget;
    }

    public function delete(Budget $budget): void
    {
        foreach ($this->repository as $key => $currentBudget) {
            if ($currentBudget->getName() == $budget->getName()) {
                unset($this->repository[$key]);
            }
        }
    }

    public function findAll(): array
    {
        return $this->repository;
    }

    public function findByName($name): Budget
    {
        foreach ($this->repository as $budget) {
            if ($budget->getName() == $name) {
                return $budget;
            }
        }
        throw new NotFoundException('Budget with name ' . $name . ' not found.');
    }

}