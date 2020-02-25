<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CategoryCreateTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreCategory()
    {
        $this
            ->signIn()
            ->withoutExceptionHandling()
            ->post('/categories', [
                'name' => 'New category'
            ])
            ->assertRedirect('/budget');

        $this->assertDatabaseHas('categories', [
            'user_id' => Auth::id(),
            'name' => 'New category'
        ]);
    }

    public function testRequireName()
    {
        $this
            ->signIn()
            ->post('/categories', [])
            ->assertSessionHasErrors('name');
    }
}
