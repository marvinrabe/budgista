<?php

namespace App\GraphQL\Queries;

use App\Models\Category;
use App\Models\Group;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Groups
{
    /**
     * Return a value for the field.
     * @param  null  $rootValue  Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args  The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context  Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo  Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $groups = Group::all();

        if (Category::whereNull('group_id')->count()) {
            $groups->add([
                'id' => null,
                'name' => 'Ungrouped',
                'sort' => $groups->max('sort') + 1,
                'categories' => Category::whereNull('group_id')->get()
            ]);
        }

        return $groups;
    }
}
