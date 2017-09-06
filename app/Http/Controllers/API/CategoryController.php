<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Category;
use App\Month;
use App\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'budget' => 'required'
        ]);

        $budget = Budget::find(Input::get('budget'));
        $this->authorize('update', $budget);

        $category = new Category();
        $category->name = Input::get('name');
        $category->budget_id = $budget->id;
        $category->sort = Category::inBudget($budget)->max('sort') + 1;
        $category->save();

        return [
            'id' => $category->id,
            'name' => $category->name
        ];
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $category->name = Input::get('name');
        $category->save();

        return [
            'id' => $category->id,
            'name' => $category->name
        ];
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return [];
    }

    public function budget(Request $request, Category $category)
    {
        $this->authorize('update', $category);

        $this->validate($request, [
            'month' => 'required',
            'amount' => 'required'
        ]);

        $month = Month::fromString(Input::get('month'));

        $categoryBudget = $category->month($month);
        $categoryBudget->amount = Input::get('amount');
        $categoryBudget->save();

        return new Row($category, $month);
    }

}
