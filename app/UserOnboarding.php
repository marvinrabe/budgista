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
        $budget->user()->associate($user);
        $budget->save();

        $accounts = [
            'Cash', 'Debit Card', 'Credit Card'
        ];

        foreach($accounts as $accountName) {
            $account = new Account();
            $account->name = $accountName;
            $account->budget()->associate($budget);
            $account->save();
        }

        $categories = [
            'Rent',  'Water & Electricity', 'Internet, Cable & Telephone', 'Car & Public Transport', 'Groceries', 'Restaurants', 'Education', 'Entertainment', 'Subscriptions', 'Emergency Fund', 'Retirement Savings'
        ];

        $i = 0;

        foreach($categories as $categoryName) {
            $category = new Category();
            $category->name = $categoryName;
            $category->budget()->associate($budget);
            $category->sort = $i++;
            $category->save();
        }

        $user->activeBudget()->associate($budget)->save();
    }

}