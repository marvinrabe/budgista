<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Category;
use App\Month;
use App\Row;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }

    public function index()
    {
        return CategoryResource::collection(Auth::user()->categories);
    }

    public function store()
    {
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
        return new CategoryResource($category);
    }

    public function update(Category $category)
    {
        $category->update(
            request()->validate([
                'name' => 'required'
            ])
        );

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
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
