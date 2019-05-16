<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolver;
use App\Models\Group;

class GroupSort extends Resolver
{

    public function respond($ids)
    {
        $sorting = array_flip($ids);

        Group::whereIn('id', $ids)->each(function($group) use ($sorting) {
            $group->sort = $sorting[$group->id];
            $group->save();
        });

        return Group::all()->fresh();
    }

}
