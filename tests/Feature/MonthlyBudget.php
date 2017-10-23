<?php

namespace Tests\Feature;

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

        foreach($dates as $date) {
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

}