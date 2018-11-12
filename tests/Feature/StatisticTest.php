<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatisticTest extends TestCase
{
    use RefreshDatabase;

    protected function prepareTransactions($user = null)
    {
        $this->signIn($user);

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
            $months[] = Carbon::now()->subMonth(11 - $i);
        }
        return $months;
    }

    /** @test */
    public function it_returns_monthly_statistics()
    {
        $this->prepareTransactions();

        $expectedData = [];
        foreach ($this->lastYearMonths() as $key => $date) {
            $expectedData[] = [
                'month' => $date->format('Y-m'),
                'worth' => $key * 100 + 100,
                'income' => 200,
                'expense' => 100
            ];
        }

        $this->get('/api/statistics/monthly')
            ->assertJson([
                'data' => $expectedData
            ]);
    }

    /** @test */
    public function it_returns_only_values_of_current_user()
    {
        $this->prepareTransactions();
        $this->prepareTransactions(factory(User::class)->create());

        $expectedData = [];
        foreach ($this->lastYearMonths() as $key => $date) {
            $expectedData[] = [
                'month' => $date->format('Y-m'),
                'worth' => $key * 100 + 100,
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
