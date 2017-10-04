<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\UserOnboarding;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BudgetForecastTest extends TestCase
{
    use RefreshDatabase;

    public function testApplication()
    {
        // Sign in User
        $user = $this->signIn();

        /** @var Budget $budget */
        $budget = $user->budgets()->first();

        /** @var Account $account */
        $account = $budget->accounts()->first();

        /** @var Category[] $categories */
        $categories = $budget->categories;
        $firstCategory = $categories[0];
        $secondCategory = $categories[1];

        // Create transactions
        factory(Transaction::class, 5)->create([
            'amount' => -10,
            'date' => Carbon::now()->subMonths(1),
            'category_id' => $firstCategory->id,
            'account_id' => $account->id
        ]);

        factory(Transaction::class)->create([
            'amount' => 100,
            'date' => Carbon::now(),
            'account_id' => $account->id
        ]);

        // Everything goes to first Category.
        $response = $this->json('GET', '/api/budgets/' . $budget->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'categories' => [
                    [
                        'id' => $firstCategory->id,
                        'forecast' => 100
                    ]
                ]
            ]);

        // Add Transactions to second category
        factory(Transaction::class, 5)->create([
            'amount' => -10,
            'date' => Carbon::now()->subMonths(1),
            'category_id' => $secondCategory->id,
            'account_id' => $account->id
        ]);

        // 100€ is split between categories
        $response = $this->json('GET', '/api/budgets/' . $budget->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'categories' => [
                    [
                        'id' => $firstCategory->id,
                        'forecast' => 50
                    ],
                    [
                        'id' => $secondCategory->id,
                        'forecast' => 50
                    ]
                ]
            ]);

        // Add some more to second category
        factory(Transaction::class, 10)->create([
            'amount' => -10,
            'date' => Carbon::now()->subMonths(1),
            'category_id' => $secondCategory->id,
            'account_id' => $account->id
        ]);

        // 100€ is split between categories and most will go to second category
        $response = $this->json('GET', '/api/budgets/' . $budget->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'categories' => [
                    [
                        'id' => $firstCategory->id,
                        'forecast' => 25
                    ],
                    [
                        'id' => $secondCategory->id,
                        'forecast' => 75
                    ]
                ]
            ]);

        // Add some older transactions to second category.
        factory(Transaction::class, 5)->create([
            'amount' => -10,
            'date' => Carbon::now()->subMonths(2),
            'category_id' => $secondCategory->id,
            'account_id' => $account->id
        ]);

        // Check splitting
        $response = $this->json('GET', '/api/budgets/' . $budget->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'categories' => [
                    [
                        'id' => $firstCategory->id,
                        'forecast' => round(5 * (100 / 15), 2)
                    ],
                    [
                        'id' => $secondCategory->id,
                        'forecast' => round(10 * (100 / 15), 2)
                    ]
                ]
            ]);

    }
}