<?php

namespace App\GraphQL\Queries;

use App\GraphQL\Resolver;
use App\Models\Category;
use App\Models\Group;

class Groups extends Resolver
{

    public function respond()
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
