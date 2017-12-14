<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category as CategoryResource;
use App\Models\Budget;
use App\Models\Category;
use App\Month;
use App\Row;
use App\Rules\Own;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function index()
    {
        return CategoryResource::collection(Auth::user()->categories);
    }

    public function store()
    {
        $this->authorize('create', Category::class);

        $category = new Category(
            request()->validate([
                'name' => 'required'
            ])
        );

        Auth::user()->categories()->save($category);

        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        $this->authorize('view', $category);

        return new CategoryResource($category);
    }

    public function update(Category $category)
    {
        $this->authorize('update', $category);

        $category->update(
            request()->validate([
                'name' => 'required'
            ])
        );

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        request()->validate([
            'category_id' => [
                'sometimes',
                new Own('categories')
            ]
        ]);

        if (request()->has('category_id')) {
            /**
             * @var Category $newCategory
             */
            $newCategory = Category::find(request('category_id'));

            $category->transactions()->update([
                'category_id' => $newCategory->id
            ]);

            $category->budgets()->get()->each(function(Budget $budget) use ($newCategory) {
                $newBudget = $newCategory->budgetIn($budget->month);
                $newBudget->amount += $budget->amount;
                $newBudget->save();
            });
        }

        $category->delete();

        return [];
    }

    public function budget(Category $category)
    {
        $this->authorize('update', $category);

        request()->validate([
            'month' => 'required',
            'amount' => 'required'
        ]);

        $month = Month::fromString(request('month'));

        $categoryBudget = $category->budgetIn($month);
        $categoryBudget->amount = request('amount');
        $categoryBudget->save();

        return new Row($category, $month);
    }

    public function sort()
    {
        request()->validate([
            'categories' => 'required'
        ]);

        $sorting = array_flip(request('categories'));

        foreach (Auth::user()->categories as $category) {
            $category->sort = $sorting[$category->id];
            $category->save();
        }

        return [];
    }

}
