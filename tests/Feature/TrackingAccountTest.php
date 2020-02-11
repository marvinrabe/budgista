<?php


namespace Tests\Feature;

use App\Budget\Month;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingAccountTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function it_does_not_include_transactions_in_budget()
    {
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

        $this->get('/api/month/' . $month)
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'income' => 30
                ]
            ]);
    }

    /** @test */
    public function it_does_not_include_transactions_in_activity()
    {
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

        $this->get('/api/month/' . $month)
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'rows' => [
                        [
                            'id' => $category->id,
                            'activity' => 30
                        ]
                    ]
                ]
            ]);
    }
}
