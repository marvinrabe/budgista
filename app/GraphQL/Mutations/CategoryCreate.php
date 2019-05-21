<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Request;
use App\GraphQL\Resolver;
use App\Models\Category;
use App\Rules\Own;

class CategoryCreate extends Resolver
{

    public function respond(Request $request, $name, $groupId = null)
    {
        $request->validate([
            'groupId' => [
                'nullable',
                new Own('groups')
            ]
        ]);

        $category = new Category();
        $category->name = $name;

        if ($groupId) {
            $category->group_id = $groupId;
        }

        $category->save();

        return $category;
    }
}
