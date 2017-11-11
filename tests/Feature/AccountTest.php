<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function accounts_have_transaction_links()
    {
        $user = $this->signIn();

        $accountId = $user->accounts()->first()->id;

        $response = $this->get('/api/accounts/' . $accountId);
        $response->assertSuccessful();

        $result = json_decode($response->getContent());

        $transactionsUrl = $result->links->transactions;
        $this->assertNotEmpty($transactionsUrl);

        $secondResponse = $this->get($transactionsUrl);
        $secondResponse->assertSuccessful();
    }
}