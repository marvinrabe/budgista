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

class ReportsIncomeVsExpenseTest extends TestCase
{
    use RefreshDatabase;

    protected function prepareTransactions($user = null)
    {
        $this->signIn($user);

        $account = factory(Account::class)->create(['user_id' => Auth()->id()]);
        $category = factory(Category::class)->create(['user_id' => Auth()->id()]);

        foreach (Month::range(...$this->lastYearMonths()) as $date) {
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
     * @return iterable|Month[]
     */
    protected function lastYearMonths()
    {
        return [
            Month::fromString(Carbon::now()->subMonthsNoOverflow(11)->format('Y-m')),
            Month::current()
        ];
    }

    public function testDisplay()
    {
        $this->signIn()
            ->get('/reports')
            ->assertInertiaViewIs('Reports')
            ->assertHasProp('incomeVsExpense');
    }

    public function testMonthlyStatistics()
    {
        $this->prepareTransactions();

        $expectedData = [];
        foreach (Month::range(...$this->lastYearMonths()) as $key => $date) {
            $expectedData[] = [
                'month' => $date->value(),
                'income' => 200,
                'expense' => 100
            ];
        }

        $response = new IncomeVsExpenseChart(... $this->lastYearMonths());

        $this->assertEquals($expectedData, $response->data()->toArray());
    }

    public function testBasedOnlyOnUserData()
    {
        $this->prepareTransactions();
        $this->prepareTransactions(factory(User::class)->create());

        $expectedData = [];
        foreach (Month::range(...$this->lastYearMonths()) as $key => $date) {
            $expectedData[] = [
                'month' => $date->value(),
                'income' => 200,
                'expense' => 100
            ];
        }

        $response = new IncomeVsExpenseChart(... $this->lastYearMonths());

        $this->assertEquals($expectedData, $response->data()->toArray());
    }
}
