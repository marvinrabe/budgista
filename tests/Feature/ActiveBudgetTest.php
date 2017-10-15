<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActiveBudgetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function active_budget_is_saved_on_user()
    {
        // Sign in User
        $user = $this->signIn();

        // Get Budget
        $budget = $user->budgets()->first();

        // User opens budget
        $response = $this->get('/budgets/' . $budget->id);

        // Everything is fine
        $response->assertStatus(200);

        // User has last open budget saved as active budget
        $this->assertEquals($budget->id, $user->active_budget_id);
    }

    /** @test */
    public function homepage_redirects_to_last_active_budget()
    {
        // Sign in User
        $user = $this->signIn();

        // Get Budget
        $budget = $user->budgets()->first();

        // User has budget active
        $user->active_budget_id = $budget->id;
        $user->save();

        // User opens budget
        $response = $this->get('/');

        // User gets redirected
        $response->assertRedirect('/budgets/' . $budget->id);
    }

}