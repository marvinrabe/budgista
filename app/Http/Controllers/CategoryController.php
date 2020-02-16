<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Budget\Month;
use App\Models\Group;
use App\Rules\Own;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{

    public function create(Request $request)
    {
        $this->authorize('create', Category::class);

        return Inertia::render('Categories/Create', [
            'group' => $request->has('group')
                ? Group::find($request->get('group'))
                : null
        ]);
    }

    public function store()
    {
        $this->authorize('create', Category::class);

        Auth::user()
            ->categories()
            ->create(request()->validate([
                'name' => 'required',
                'group_id' => [
                    'nullable',
                    new Own('groups')
                ]
            ]));

        return Redirect::route('budget');
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
                'name' => 'required',
                'group_id' => [
                    'nullable',
                    new Own('groups')
                ]
            ])
        );

        return Redirect::route('budget');
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

        return Redirect::route('budget');
    }

    public function sort()
    {
        request()->validate([
            'group_id' => [
                'nullable',
                'string',
                new Own('groups'),
            ],
            'categories' => 'required'
        ]);

        $categories = request('categories');

        $sorting = array_flip($categories);

        foreach (Auth::user()->categories as $category) {
            if (in_array($category->id, $categories)) {
                $category->sort = $sorting[$category->id];
                $category->group_id = request('group_id');
                $category->save();
            }
        }

        return Redirect::back();
    }

}
