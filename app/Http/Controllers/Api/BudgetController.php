<?php

namespace App\Http\Controllers\Api;

use App\Month;
use App\ViewModels\Budget;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BudgetController
{
    use AuthorizesRequests;

    public function index($month)
    {
        return new Budget($this->getMonth($month));
    }

    private function getMonth($string): Month
    {
        try {
            return Month::fromString($string);
        } catch (\InvalidArgumentException $exception) {
            abort(404);
        }
    }
}
