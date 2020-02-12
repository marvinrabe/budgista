<?php

namespace Tests\Feature;

use App\Budget\Month;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
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
            ->assertInertiaViewIs('Budget')
            ->assertHasProp('budget')
            ->assertHasProp('groups')
            ->assertHasProp('links')
            ->assertHasProp('month');
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

        $row = Collection::make($response->props('budget')['rows'])
            ->where('id', $category->id)
            ->first();

        $this->assertEquals(-20, $row['activity']);
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

        $response = $this->get('/budget/'.$month)
            ->assertSuccessful();

        $row = Collection::make($response->props('budget')['rows'])
            ->where('id', $category->id)
            ->first();

        $this->assertEquals(10, $row['previousMonth']);
        $this->assertEquals(10, $row['recommendedBudget']);
    }

    /** @test */
    public function it_saves_budget()
    {
        $category = factory(Category::class)->create();
        $month = Month::current();

        $this
            ->signIn($category->user)
            ->put('/api/categories/'.$category->id.'/budget', [
                'month' => (string) $month,
                'amount' => 123456
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('budgets', [
            'category_id' => $category->id,
            'month' => (string) $month,
            'amount' => 123456
        ]);
    }

    /** @test */
    public function it_cleans_the_database()
    {
        $category = factory(Category::class)->create();
        $month = Month::current();

        $category->budget($month)->update([
            'amount' => 0
        ]);

        $category->budget($month->previous())->update([
            'amount' => 123
        ]);

        $this->assertEquals(2, DB::table('budgets')->count());

        Artisan::call('app:clean');

        $this->assertEquals(1, DB::table('budgets')->count());
        $this->assertEquals(0, DB::table('budgets')->where('amount', '=', 0)->count());
    }

}
