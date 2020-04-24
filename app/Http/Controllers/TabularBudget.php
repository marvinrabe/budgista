<?php

namespace App\Http\Controllers;

use App\Month;
use App\ViewModels\Budget;
use Inertia\Inertia;

class TabularBudget
{

    public function __invoke($month = null)
    {
        $month = $this->getMonth($month);

        return Inertia::render('Budget/Tabular', [
            'budget' => (new Budget($month))->toArray()
        ]);
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
