<?php

namespace App\Http\Controllers;

use App\Budget\Month;
use Auth;

class MonthlyBudgetController extends Controller
{

    public function show($month = null)
    {
        $month = $this->getMonth($month);

        return [
            'data' => Auth::user()->budget($month),
            'links' => [
                'prev' => route('month', ['month' => $month->previous()]),
                'next' => route('month', ['month' => $month->next()])
            ]
        ];
    }

    private function getMonth($string)
    {
        try {
            if (!empty($string)) {
                return Month::fromString($string);
            }

            return Month::current();
        } catch (\InvalidArgumentException $exception) {
            abort(404);
        }
    }

}
