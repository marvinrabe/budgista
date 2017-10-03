<?php

namespace App;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\User;

class UserOnboarding
{

    public static function for(User $user)
    {
        $budget = new Budget();
        $budget->name = 'My Budget';
        $budget->user_id = $user->id;
        $budget->save();

        $accounts = [
            'Cash', 'Debit Card', 'Credit Card'
        ];

        foreach($accounts as $accountName) {
            $account = new Account();
            $account->name = $accountName;
            $account->budget_id = $budget->id;
            $account->save();
        }

        $categories = [
            'Groceries', 'Restaurants', 'Utilities', 'Rent', 'Hobbies'
        ];

        foreach($categories as $categoryName) {
            $category = new Category();
            $category->name = $categoryName;
            $category->budget_id = $budget->id;
            $category->save();
        }
    }

}