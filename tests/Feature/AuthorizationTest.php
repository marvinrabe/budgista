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

    protected $budget_id = '8c37f1ae-e90c-4a9d-8d87-169a5d4a1448';

    protected $adam;

    protected $eve;

    protected $routes;

    protected $budget;

    public function setUp() {
        parent::setUp();

        $this->adam = factory(User::class)->create();
        $this->eve = factory(User::class)->create();

        $this->budget = factory(Budget::class)->make([
            'user_id' => $this->adam->id
        ]);
        $this->budget->save();
    }


    public function getRoutes() {
        return [
            ['/budgets/%s/edit'],
            ['/budgets/%s/month'],
            ['/budgets/%s/month/2017-09'],
            ['/budgets/%s/accounts/create'],
            ['/budgets/%s/categories/create'],
            ['/budgets/%s/transactions/create'],
        ];
    }

    /**
     * A basic test example.
     * @dataProvider getRoutes
     * @return void
     */
    public function testBadAccess($route)
    {
        $response = $this->actingAs($this->eve)
            ->get(sprintf($route, $this->budget->id));

        $response->assertStatus(403);
    }

    /**
     * A basic test example.
     * @dataProvider getRoutes
     * @return void
     */
    public function testValidAccess($route)
    {
        $response = $this->actingAs($this->adam)
            ->get(sprintf($route, $this->budget->id));

        $response->assertStatus(200);
    }

}
