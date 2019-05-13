<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Errors\ValidationError;
use App\Models\Budget;
use App\Models\Category;
use App\Rules\Own;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CategoryDelete
{
    /**
     * Return a value for the field.
     * @param  null  $rootValue  Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args  The arguments that were passed into the field.
     * @param  GraphQLContext  $context  Arbitrary data that is shared between all fields of a single query.
     * @param  ResolveInfo  $resolveInfo  Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     * @throws ValidationError
     */
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        Validator::make($args, [
            'transferToCategoryId' => [
                'nullable',
                new Own('categories')
            ]
        ])->validate();

        $category = Category::findOrFail($args['id']);

        if (!empty($args['transferToCategoryId'])) {
            /**
             * @var Category $newCategory
             */
            $newCategory = Category::find($args['transferToCategoryId']);

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
