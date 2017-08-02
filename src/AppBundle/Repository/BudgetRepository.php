<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Budget;

interface BudgetRepository
{

    public function save(Budget $budget): void;

    public function remove(Budget $budget): void;

}