<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Category;
use App\Month;
use App\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }

    public function index()
    {
        $budget = Auth::user()->activeBudget;

        $this->authorize('view', $budget);

        return CategoryResource::collection($budget->categories()->get());
    }

    public function store(Request $request)
    {
        $budget = Auth::user()->activeBudget;

        $this->validate($request, [
            'name' => 'required'
        ]);

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

    public function sort(Request $request)
    {
        $budget = Auth::user()->activeBudget;

        $this->authorize('update', $budget);

        $this->validate($request, [
            'categories' => 'required'
        ]);

        foreach (Input::get('categories') as $key => $category_id) {
            $category = Category::find($category_id);
            $category->sort = $key;
            $category->save();
        }

        return [];
    }

}
