<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Category;
use App\Month;
use App\Row;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category = new Category();
        $category->name = request('name');
        $category->sort = Auth::user()->categories()->max('sort') + 1;

        Auth::user()->categories()->save($category);

        return [
            'id' => $category->id,
            'name' => $category->name
        ];
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category->name = request('name');
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

        $request->validate([
            'month' => 'required',
            'amount' => 'required'
        ]);

        $month = Month::fromString(request('month'));

        $categoryBudget = $category->budgetedIn($month);
        $categoryBudget->amount = request('amount');
        $categoryBudget->save();

        return new Row($category, $month);
    }

    public function sort(Request $request)
    {
        $request->validate([
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
