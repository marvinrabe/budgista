<?php


namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserInactiveTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp() {
        parent::setUp();

        $this->user = factory(User::class)->create();

        factory(Account::class)->create([
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    public function it_marks_user_as_inactive()
    {
        $this->assertFalse($this->user->isActive());
    }

    /** @test */
    public function it_marks_user_as_active()
    {
        factory(Transaction::class)->create([
            'date' => Carbon::now(),
            'account_id' => $this->user->accounts->first()->id
        ]);

        $this->assertTrue($this->user->isActive());
    }

    /** @test */
    public function it_marks_user_as_active_when_transaction_is_30_days_old()
    {
        factory(Transaction::class)->create([
            'date' => Carbon::now()->subDays(30),
            'account_id' => $this->user->accounts->first()->id
        ]);

        $this->assertTrue($this->user->isActive());
    }

    /** @test */
    public function it_mark_user_as_inactive_when_last_transaction_is_31_days_old()
    {
        factory(Transaction::class)->create([
            'date' => Carbon::now()->subDays(31),
            'account_id' => $this->user->accounts->first()->id
        ]);

        $this->assertFalse($this->user->isActive());
    }

    /** @test */
    public function it_marks_user_as_inactive_when_there_are_a_equal_amount_of_future_transactions()
    {
        factory(Transaction::class)->create([
            'date' => Carbon::now(),
            'account_id' => $this->user->accounts->first()->id
        ]);

        factory(Transaction::class)->create([
            'date' => Carbon::now()->addDays(1),
            'account_id' => $this->user->accounts->first()->id
        ]);

        $this->assertFalse($this->user->isActive());
    }

}