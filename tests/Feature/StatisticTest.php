<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatisticTest extends TestCase
{
    use RefreshDatabase;

    protected function prepareTransactions()
    {
        $this->signIn();

        $account = factory(Account::class)->create(['user_id' => Auth()->id()]);
        $category = factory(Category::class)->create(['user_id' => Auth()->id()]);

        foreach ($this->lastYearMonths() as $date) {
            foreach ([-100, 200] as $amount) {
                factory(Transaction::class)->create([
                    'account_id' => $account->id,
                    'category_id' => $amount < 0 ? $category->id : null,
                    'date' => $date,
                    'amount' => $amount
                ]);
            }
        }
    }

    protected function lastYearMonths()
    {
        $months = [];
        for ($i = 0; $i <= 11; $i++) {
            $months[] = Carbon::now()->subMonth($i);
        }
        return $months;
    }

    /** @test */
    public function it_returns_monthly_statistics()
    {
        $this->prepareTransactions();

        $expectedData = [];
        foreach ($this->lastYearMonths() as $key => $date) {
            $expectedData[$date->format('Y-m')] = [
                'worth' => 12 * 100 - $key * 100,
                'income' => 200,
                'expense' => 100
            ];
        }

        $this->get('/api/statistics/monthly')
            ->assertJson([
                'data' => $expectedData
            ]);
    }
}
