<?php

namespace Tests\Feature;

use App\Account;
use App\Category;
use App\Month;
use App\Transaction;
use App\User;
use App\ViewModels\IncomeVsExpenseChart;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatisticsIncomeVsExpenseTest extends TestCase
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
                    'user_id' => Auth()->id(),
                    'account_id' => $account->id,
                    'category_id' => $amount < 0 ? $category->id : null,
                    'date' => $date->firstDay(),
                    'amount' => $amount
                ]);
            }
        }
    }

    /**
     * @return Month[]
     */
    protected function lastYearMonths()
    {
        $months = [];
        for ($i = 0; $i <= 11; $i++) {
            $months[] = Month::fromString(Carbon::now()->subMonthNoOverflow(11 - $i)->format('Y-m'));
        }
        return $months;
    }

    public function testDisplay()
    {
        $this->signIn()
            ->get('/statistics/incomeVsExpense')
            ->assertInertiaViewIs('Statistics/IncomeVsExpense')
            ->assertHasProp('data');
    }

    public function testMonthlyStatistics()
    {
        $this->prepareTransactions();

        $expectedData = [];
        foreach ($this->lastYearMonths() as $key => $date) {
            $expectedData[] = [
                'month' => $date->value(),
                'income' => 200,
                'expense' => 100
            ];
        }

        $response = new IncomeVsExpenseChart($this->lastYearMonths());

        $this->assertEquals($expectedData, $response->data()->toArray());
    }

    public function testBasedOnlyOnUserData()
    {
        $this->prepareTransactions();
        $this->prepareTransactions(factory(User::class)->create());

        $expectedData = [];
        foreach ($this->lastYearMonths() as $key => $date) {
            $expectedData[] = [
                'month' => $date->value(),
                'income' => 200,
                'expense' => 100
            ];
        }

        $response = new IncomeVsExpenseChart($this->lastYearMonths());

        $this->assertEquals($expectedData, $response->data()->toArray());
    }

    public function testReturnsLastTwelveMonths()
    {
        $knownDate = Carbon::create(2018, 11, 30); // create testing date
        Carbon::setTestNow($knownDate);
        $this->prepareTransactions();

        $expected = ['2017-12'];
        for ($month = 1; $month <= 11; $month++) {
            $expected[] = '2018-'.str_pad($month, 2, '0', STR_PAD_LEFT);
        }

        $response = new IncomeVsExpenseChart($this->lastYearMonths());

        $result = $response->data()
            ->map(function ($item) {
                return $item['month'];
            })
            ->toArray();

        $this->assertTrue(array_diff($expected, $result) == []);
    }
}
