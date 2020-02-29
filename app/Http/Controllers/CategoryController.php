<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Category;
use App\Rules\Own;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function store()
    {
        Auth::user()
            ->categories()
            ->create(request()->validate([
                'name' => 'required'
            ]));

        return Redirect::route('categories.index');
    }

    public function edit(Category $category)
    {
        $this->authorize('view', $category);

        return Inertia::render('Categories/Edit', [
            'category' => $category
        ]);
    }

    public function update(Category $category)
    {
        $this->authorize('update', $category);

        $category->update(
            request()->validate([
                'name' => 'required'
            ])
        );

        return Redirect::route('categories.index');
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

        return Redirect::route('categories.index');
    }

    public function sort()
    {
        request()->validate([
            'categories' => ['required', 'array']
        ]);

        $categories = request('categories');

        $sorting = array_flip($categories);

        foreach (Auth::user()->categories as $category) {
            if (in_array($category->id, $categories)) {
                $category->update([
                    'sort' => $sorting[$category->id]
                ]);
            }
        }

        return Redirect::back();
    }

}
