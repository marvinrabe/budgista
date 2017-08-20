<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CategoryController extends Controller
{

    public function create(Budget $budget)
    {
        return View::make('categories.create')
            ->with('budget', $budget);
    }

    public function store(Budget $budget)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('categories.create', [$budget->id])
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $category = new Category();
        $category->name = Input::get('name');
        $category->budget_id = $budget->id;
        $category->save();

        // redirect
        Session::flash('message', 'Successfully created category!');
        return redirect()->route('sheet', [$budget->id]);
    }

    public function edit(Budget $budget, Category $category)
    {
        return View::make('categories.edit')
            ->with('category', $category)
            ->with('budget', $budget);
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

}
