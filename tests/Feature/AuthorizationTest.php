<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorizationTest extends TestCase
{
    use DatabaseMigrations;

    protected $adam;

    protected $eve;

    protected $routes;

    public function setup() {
        $this->adam = factory(User::class)->create();
        $this->eve = factory(User::class)->create();

        $budget = factory(Budget::class)->make([
            'user_id' => $this->adam->id
        ]);

        $this->routes = [
            //'/budgets/'.$budget->id,
            '/budgets/'.$budget->id.'/edit',
            '/budgets/'.$budget->id.'/month',
            '/budgets/'.$budget->id.'/month/2017-09',
            '/budgets/'.$budget->id.'/accounts/create',
            '/budgets/'.$budget->id.'/categories/create',
            '/budgets/'.$budget->id.'/transactions/create',
        ];
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBadAccess()
    {
        foreach($this->routes as $route) {
            $response = $this->actingAs($this->eve)
                ->withSession(['foo' => 'bar'])
                ->get($route);

            $response->assertStatus(401);
        }
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testValidAccess()
    {
        foreach($this->routes as $route) {
            $response = $this->actingAs($this->adam)
                ->withSession(['foo' => 'bar'])
                ->get($route);

            $response->assertStatus(200);
        }
    }
}
