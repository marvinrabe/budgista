<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category as CategoryResource;
use App\Models\Budget;
use App\Models\Category;
use App\Budget\Month;
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
                'nullable',
                new Own('categories')
            ]
        ]);

        if (!empty(request('category_id'))) {
            /**
             * @var Category $newCategory
             */
            $newCategory = Category::find(request('category_id'));

            $category->transactions()->update([
                'category_id' => $newCategory->id
            ]);

            $category->budgets()->get()->each(function (Budget $budget) use ($newCategory) {
                $newBudget = $newCategory->budget($budget->month);
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

        $budget = $category->budget($month);

        $budget->update(
            request(['amount'])
        );

        return $budget;
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
