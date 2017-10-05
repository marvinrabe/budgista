<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateMultipleBudgetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_additional_budgets()
    {
        // Sign in User
        $user = $this->signIn();

        // Create Budget
        $response = $this->post('/budgets', [
            'name' => 'New Test Budget',
            'currency' => 'USD'
        ]);

        $response->assertRedirect('/budgets');

        // New Budget is in database
        $this->assertDatabaseHas('budgets', [
            'user_id' => $user->id,
            'name' => 'New Test Budget',
            'currency' => 'USD'
        ]);
    }
}
