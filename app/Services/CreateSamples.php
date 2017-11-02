<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Category;
use App\Models\User;

class CreateSamples
{

    public static function for(User $user)
    {
        $accounts = trans('samples.accounts');

        foreach ($accounts as $accountName) {
            $account = new Account();
            $account->name = $accountName;
            $user->accounts()->save($account);
        }

        $categories = trans('samples.categories');

        foreach ($categories as $i => $categoryName) {
            $category = new Category();
            $category->name = $categoryName;
            $category->sort = $i++;
            $user->categories()->save($category);
        }
    }

}