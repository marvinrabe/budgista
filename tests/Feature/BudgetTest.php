<?php

namespace Tests\Feature;

use App\Month;
use App\Account;
use App\Category;
use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BudgetTest extends TestCase
{
    use RefreshDatabase;

    public function testDisplayBudget()
    {
        $this->signIn()
            ->get('/budget')
            ->assertInertiaViewIs('Budget/Index')
            ->assertHasProp('budget');
    }

    public function testIncome()
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
                'user_id' => Auth()->id(),
                'account_id' => $account->id
            ]);
        }

        $response = $this->get('/budget/'.$month)
            ->assertSuccessful();

        $this->assertEquals(20, $response->props('budget')['income']);
    }

    public function testActivity()
    {
        $this->signIn();

        $month = Month::current();

        $category = factory(Category::class)->create([
            'user_id' => Auth()->id()
        ]);

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
                'amount' => -10,
                'date' => $date,
                'category_id' => $category->id,
                'account_id' => $account->id,
                'user_id' => Auth()->id(),
            ]);
        }

        $response = $this->get('/budget/'.$month)
            ->assertSuccessful();

        $row = Collection::make($response->props('budget')['categories'])
            ->where('id', $category->id)
            ->first();

        $this->assertEquals(-20, $row['activity']);
    }

    public function testBudgetWithoutTrackingAccounts()
    {
        $this->signIn();

        $month = Month::current();

        $trackingAccount = factory(Account::class)
            ->states('tracking')
            ->create([
                'user_id' => Auth()->id()
            ]);

        $normalAccount = factory(Account::class)
            ->create([
                'user_id' => Auth()->id()
            ]);

        factory(Transaction::class)->create([
            'amount' => 20,
            'date' => $month->firstDay(),
            'account_id' => $trackingAccount->id,
            'user_id' => Auth()->id()
        ]);

        factory(Transaction::class)->create([
            'amount' => 30,
            'date' => $month->firstDay(),
            'account_id' => $normalAccount->id,
            'user_id' => Auth()->id()
        ]);

        $response = $this->get('/budget/'.$month)->assertSuccessful();

        $this->assertEquals(30, $response->props('budget')['income']);
    }

    public function testActivityWithoutTrackingAccounts()
    {
        $this->signIn();

        $month = Month::current();

        $category = factory(Category::class)->create([
            'user_id' => Auth()->id()
        ]);

        $trackingAccount = factory(Account::class)
            ->states('tracking')
            ->create([
                'user_id' => Auth()->id()
            ]);

        $normalAccount = factory(Account::class)
            ->create([
                'user_id' => Auth()->id()
            ]);

        factory(Transaction::class)->create([
            'amount' => 20,
            'date' => $month->firstDay(),
            'category_id' => $category->id,
            'account_id' => $trackingAccount->id,
            'user_id' => Auth()->id()
        ]);

        factory(Transaction::class)->create([
            'amount' => 30,
            'date' => $month->firstDay(),
            'category_id' => $category->id,
            'account_id' => $normalAccount->id,
            'user_id' => Auth()->id()
        ]);

        $response = $this->get('/budget/'.$month)->assertSuccessful();

        $row = Collection::make($response->props('budget')['categories'])
            ->where('id', $category->id)
            ->first();

        $this->assertEquals(30, $row['activity']);
    }

    public function testRecommendedBudget()
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

        $budgetLastMonth = $category->budget($month->previous());
        $budgetLastMonth->amount = 10;
        $budgetLastMonth->save();

        factory(Transaction::class)->create([
            'amount' => -30,
            'date' => $month->next()->firstDay(),
            'account_id' => $account->id,
            'category_id' => $category->id,
            'user_id' => Auth()->id()
        ]);

        $response = $this->get("/budget/{$month}/categories/{$category->id}")
            ->assertSuccessful();

        $budget = $response->props('categoryBudget');

        $this->assertEquals(10, $budget['previousMonth']);
        $this->assertEquals(10, $budget['recommendedBudget']);
    }

    public function testStoreBudget()
    {
        $category = factory(Category::class)->create();
        $month = Month::current();

        $this
            ->signIn($category->user)
            ->from("/budget/{$month}")
            ->post("/budget/{$month}/categories/{$category->id}", [
                'amount' => 123456
            ])
            ->assertRedirect("/budget/{$month}");

        $this->assertDatabaseHas('budgets', [
            'category_id' => $category->id,
            'month' => (string) $month,
            'amount' => 123456
        ]);
    }

    public function testCleanDatabase()
    {
        $category = factory(Category::class)->create();
        $month = Month::current();

        $category->budget($month)->fill([
            'amount' => 0
        ])->save();

        $category->budget($month->previous())->fill([
            'amount' => 123
        ])->save();

        $this->assertEquals(2, DB::table('budgets')->count());

        Artisan::call('app:clean');

        $this->assertEquals(1, DB::table('budgets')->count());
        $this->assertEquals(0, DB::table('budgets')->where('amount', '=', 0)->count());
    }

}
