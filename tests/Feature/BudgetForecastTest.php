<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use App\UserOnboarding;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BudgetForecastTest extends TestCase
{
    use RefreshDatabase;

    public function testApplication()
    {
        /** Create User
         * @var User $adam
         */
        $adam = factory(User::class)->create();
        $eve = factory(User::class)->create();

        // Create Basic Structure
        UserOnboarding::for ($adam);

        // Create Transactions

        /** @var Budget $budget */
        $budget = $adam->budgets()->first();

        /** @var Account $account */
        $account = $budget->accounts()->first();

        /** @var Category[] $categories */
        $categories = $budget->categories;

        $firstCategory = $categories[0];

        factory(Transaction::class, 5)->create([
            'amount' => -10,
            'date' => Carbon::now()->subMonths(1),
            'category_id' => $firstCategory->id,
            'account_id' => $account->id,
            'budget_id' => $budget->id
        ]);

        factory(Transaction::class)->create([
            'amount' => 100,
            'date' => Carbon::now(),
            'account_id' => $account->id,
            'budget_id' => $budget->id
        ]);

        // Authentication for API
        Passport::actingAs($adam);

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
        $secondCategory = $categories[1];

        factory(Transaction::class, 5)->create([
            'amount' => -10,
            'date' => Carbon::now()->subMonths(1),
            'category_id' => $secondCategory->id,
            'account_id' => $account->id,
            'budget_id' => $budget->id
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
            'account_id' => $account->id,
            'budget_id' => $budget->id
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
            'account_id' => $account->id,
            'budget_id' => $budget->id
        ]);

        // Check splitting
        $response = $this->json('GET', '/api/budgets/' . $budget->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'categories' => [
                    [
                        'id' => $firstCategory->id,
                        'forecast' => round(5*(100/15), 2)
                    ],
                    [
                        'id' => $secondCategory->id,
                        'forecast' => round(10*(100/15), 2)
                    ]
                ]
            ]);

        $this->assertTrue(true);
    }
}