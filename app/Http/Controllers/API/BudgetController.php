<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account as AccountResource;
use App\Http\Resources\Budget as BudgetResource;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Budget;
use App\Month;
use Illuminate\Http\Request;

class BudgetController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Budget::class);
    }

    public function show(Budget $budget)
    {
        return new BudgetResource($budget);
    }

    public function accounts(Budget $budget)
    {
        $this->authorize('view', $budget);

        return AccountResource::collection($budget->accounts()->get());
    }

    public function categories(Budget $budget)
    {
        $this->authorize('view', $budget);

        return CategoryResource::collection($budget->categories()->get());
    }

    public function month(Budget $budget, $month = null)
    {
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

    public function sort(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        $this->validate($request, [
            'categories' => 'required'
        ]);

        foreach(Input::get('categories') as $key => $category_id) {
            $category = Category::find($category_id);
            $category->sort = $key;
            $category->save();
        }

        return [];
    }

}
