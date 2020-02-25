<?php

namespace App\Http\Controllers;

use App\Month;
use App\Category;
use App\ViewModels\Budget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class BudgetController extends Controller
{

    public function index($month = null)
    {
        $month = $this->getMonth($month);

        return Inertia::render('Budget/Index', [
            'budget' => (new Budget($month))->toArray()
        ]);
    }

    public function show($month, Category $category)
    {
        $month = $this->getMonth($month);

        return Inertia::render('Budget/Show', [
            'budget' => (new Budget($month))->toArray(),
            'category' => $category,
            'categoryBudget' => $category->budget($month),
            'transactions' => $category
                ->transactions()
                ->whereBetween('date', [
                    $month->firstDay(),
                    $month->lastDay()
                ])
                ->with(['category', 'account'])
                ->orderBy('date', 'desc')
                ->paginate(25),
        ]);
    }

    public function store($month, Category $category)
    {
        $month = $this->getMonth($month);

        $this->authorize('update', $category);

        request()->validate([
            'amount' => 'required'
        ]);

        $category
            ->budget($month)
            ->update(
                request(['amount'])
            );

        return Redirect::back();
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
