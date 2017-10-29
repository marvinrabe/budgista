<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Month;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonthlyBudget extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_funds()
    {
        $user = $this->signIn();

        $month = Month::current();

        $dates = [
            $month->firstDay(),
            $month->lastDay(),
            $month->next()->firstDay(),
            $month->previous()->lastDay()
        ];

        foreach ($dates as $date) {
            factory(\App\Models\Transaction::class)->create([
                'amount' => 10,
                'date' => $date,
                'account_id' => $user->accounts()->first()->id,
            ]);
        }


        $response = $this->get('/api/month/' . $month);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'funds' => 20
            ]
        ]);
    }

    /** @test */
    public function calculate_minimum_budgeted()
    {

        $user = $this->signIn();

        $month = Month::current();

        /**
         * @var Category $category
         */
        $category = $user->categories()->first();
        $budgetLastMonth = $category->budgetIn($month->previous());

        $budgetLastMonth->amount = 10;
        $budgetLastMonth->save();

        factory(\App\Models\Transaction::class)->create([
            'amount' => -30,
            'date' => $month->next()->firstDay(),
            'account_id' => $user->accounts()->first()->id,
            'category_id' => $category->id
        ]);

        $response = $this->get('/api/month/' . $month);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'rows' => [[
                    'id' => $category->id,
                    'previousMonth' => 10,
                    'recommendedBudget' => 10
                ]]
            ]
        ]);
    }

}