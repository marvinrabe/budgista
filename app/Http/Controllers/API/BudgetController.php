<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account as AccountResource;
use App\Http\Resources\Budget as BudgetResource;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Budget;
use App\Month;
use Auth;
use Illuminate\Http\Request;

class BudgetController extends Controller
{

    public function show()
    {
        $budget = Auth::user()->activeBudget;

        return new BudgetResource($budget);
    }

    public function month($month = null)
    {
        $budget = Auth::user()->activeBudget;

        $this->authorize('view', $budget);

        $month = $this->getMonth($month);

        return [
            'data' => $budget->month($month),
            'links' => [
                'prev' => route('budgets.month', [$budget, 'month' => $month->previous()]),
                'next' => route('budgets.month', [$budget, 'month' => $month->next()])
            ]
        ];
    }

    private function getMonth($string)
    {
        try {
            if ($string !== null) {
                return Month::fromString($string);
            }

            return Month::current();
        } catch (\InvalidArgumentException $exception) {
            abort(404);
        }
    }

}
