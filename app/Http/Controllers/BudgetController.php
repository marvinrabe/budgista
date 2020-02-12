<?php

namespace App\Http\Controllers;

use App\Budget\Month;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class BudgetController extends Controller
{

    public function __invoke($month = null)
    {
        $month = $this->getMonth($month);

        return Inertia::render('Budget', [
            'month' => (string) $month,
            'budget' => Auth::user()->budget($month),
            'groups' => Auth::user()->groups()->with('categories')->get(),
            'links' => [
                'prev' => URL::route('budget', ['month' => $month->previous()]),
                'next' => URL::route('budget', ['month' => $month->next()])
            ]
        ]);
    }

    private function getMonth($string): Month
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
