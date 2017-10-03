<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function getRoutes() {
        return [
            '/budgets/%s/edit',
            '/api/budgets/%s/month/',
            '/api/budgets/%s/month/2017-09',
            '/api/budgets/%s/accounts',
            '/api/budgets/%s/categories'
        ];
    }

    /**
     * A basic test example.
     * @return void
     */
    public function testBadAccess()
    {
        // Create Users
        $adam = factory(User::class)->create();
        $eve = factory(User::class)->create();

        // Create Budget
        $budget = factory(Budget::class)->make([
            'user_id' => $adam->id
        ]);
        $budget->save();


        $routes = $this->getRoutes();

        // Good Access
        Passport::actingAs($adam);

        foreach($routes as $route) {
            $goodResponse = $this->actingAs($adam)
                ->get(sprintf($route, $budget->id));

            $goodResponse->assertStatus(200);
        }

        // Bad Access
        Passport::actingAs($eve);

        foreach($routes as $route) {
            $badResponse = $this->actingAs($eve)
                ->get(sprintf($route, $budget->id));

            $badResponse->assertStatus(403);
        }
    }

}
