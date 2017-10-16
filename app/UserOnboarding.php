<?php

namespace App;

use App\Models\Account;
use App\Models\Category;
use App\Models\User;

class UserOnboarding
{

    public static function for(User $user)
    {
        $accounts = [
            'Cash', 'Debit Card', 'Credit Card'
        ];

        foreach ($accounts as $accountName) {
            $account = new Account();
            $account->name = $accountName;
            $user->accounts()->save($account);
        }

        $categories = [
            'Rent', 'Water & Electricity', 'Internet, Cable & Telephone', 'Car & Public Transport', 'Groceries', 'Restaurants', 'Education', 'Entertainment', 'Subscriptions', 'Emergency Fund', 'Retirement Savings'
        ];

        foreach ($categories as $i => $categoryName) {
            $category = new Category();
            $category->name = $categoryName;
            $category->sort = $i++;
            $user->categories()->save($category);
        }
    }

}