<?php

namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function accounts_have_transaction_links()
    {
        $this->signIn();

        $account = factory(Account::class)->create([
            'user_id' => Auth()->id()
        ]);

        $response = $this->getJson('/api/accounts/' . $account->id);
        $response->assertSuccessful();

        $result = json_decode($response->getContent());

        $transactionsUrl = $result->links->transactions;

        $this->get($transactionsUrl)->assertSuccessful();
    }
}