<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Request;
use App\GraphQL\Resolver;
use App\Models\Budget;
use App\Models\Category;
use App\Rules\Own;

class CategoryDelete extends Resolver
{

    public function respond(Request $request, Category $category, $transferToCategoryId = null)
    {
        $request->validate([
            'transferToCategoryId' => [
                'nullable',
                new Own('categories')
            ]
        ]);

        if ($transferToCategoryId) {
            /**
             * @var Category $newCategory
             */
            $newCategory = Category::find($transferToCategoryId);

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

        return $category;
    }
}
