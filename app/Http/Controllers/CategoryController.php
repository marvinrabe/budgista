<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\CategoryBudget;
use App\Month;
use App\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }

    public function store(Budget $budget)
    {

        $rules = array(
            'name' => 'required',
            'budget' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

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

    public function update(Budget $budget, Category $category)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('categories.edit', [$budget->id, $category->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $category->name = Input::get('name');
        $category->save();

        // redirect
        Session::flash('message', 'Successfully updated category!');
        return redirect()->route('sheet', [$budget->id]);
    }

    public function destroy(Budget $budget, Category $category)
    {
        $category->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the category!');
        return redirect()->route('sheet', [$budget->id]);
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
