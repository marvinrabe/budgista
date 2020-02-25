<?php

namespace App\Http\Controllers;

use App\Month;
use App\ViewModels\Budget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class TabularBudget
{

    public function __invoke($month = null)
    {
        $month = $this->getMonth($month);

        return Inertia::render('Budget/Tabular', [
            'budget' => (new Budget($month))->toArray(),
            'links' => [
                'prev' => URL::route('budget.tabular', ['month' => $month->previous()]),
                'next' => URL::route('budget.tabular', ['month' => $month->next()])
            ]
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
