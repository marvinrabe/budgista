<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Month;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonthlyBudgetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_funds()
    {
        $this->signIn();

        $month = Month::current();

        $account = factory(Account::class)->create([
            'user_id' => Auth()->id()
        ]);

        $dates = [
            $month->firstDay(),
            $month->lastDay(),
            $month->next()->firstDay(),
            $month->previous()->lastDay()
        ];

        foreach ($dates as $date) {
            factory(Transaction::class)->create([
                'amount' => 10,
                'date' => $date,
                'account_id' => $account->id,
            ]);
        }

        $this->get('/api/month/' . $month)
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'income' => 20
                ]
            ]);
    }

    /** @test */
    public function check_activity()
    {
        $this->signIn();

        $month = Month::current();

        $category = factory(Category::class)->create([
            'user_id' => Auth()->id()
        ]);

        $dates = [
            $month->firstDay(),
            $month->lastDay(),
            $month->next()->firstDay(),
            $month->previous()->lastDay()
        ];

        foreach ($dates as $date) {
            factory(Transaction::class)->create([
                'amount' => -10,
                'date' => $date,
                'category_id' => $category->id
            ]);
        }

        $this->get('/api/month/' . $month)
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'rows' => [
                        [
                            'id' => $category->id,
                            'activity' => -20
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function calculate_minimum_budgeted()
    {
        $this->signIn();

        $month = Month::current();

        /**
         * @var Category $category
         */
        $category = factory(Category::class)->create([
            'user_id' => Auth()->id()
        ]);

        $account = factory(Account::class)->create([
            'user_id' => Auth()->id()
        ]);

        $budgetLastMonth = $category->budgetIn($month->previous());
        $budgetLastMonth->amount = 10;
        $budgetLastMonth->save();

        factory(Transaction::class)->create([
            'amount' => -30,
            'date' => $month->next()->firstDay(),
            'account_id' => $account->id,
            'category_id' => $category->id
        ]);

        $this->get('/api/month/' . $month)
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'rows' => [
                        [
                            'id' => $category->id,
                            'previousMonth' => 10,
                            'recommendedBudget' => 10
                        ]
                    ]
                ]
            ]);
    }

}