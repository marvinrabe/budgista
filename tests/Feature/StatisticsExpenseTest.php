<?php

namespace Tests\Feature;

use App\Account;
use App\Category;
use App\Month;
use App\Transaction;
use App\User;
use App\ViewModels\ExpenseChart;
use App\ViewModels\IncomeChart;
use App\ViewModels\NetWorthChart;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatisticsExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function testDisplay()
    {
        $this->signIn()
            ->get('/statistics/expense')
            ->assertInertiaViewIs('Statistics/Expense')
            ->assertHasProp('data');
    }

    public function testBasedOnlyOnUserData()
    {
        $this->signIn();

        // Transaction from a different user
        factory(Transaction::class)->create([
            'amount' => -123
        ]);

        $response = new ExpenseChart(Month::current(), Month::current());

        $this->assertEquals([], $response->data()->toArray());
    }
}
