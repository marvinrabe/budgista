<?php

namespace Tests\Feature;

use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryEditTest extends TestCase
{

    use RefreshDatabase;

    public function testUpdateCategory()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn($category->user)
            ->put("/categories/{$category->id}", [
                'name' => 'New Name'
            ])
            ->assertRedirect('/budget');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => 'New Name'
        ]);
    }

    public function testRequireName()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn($category->user)
            ->put("/categories/{$category->id}", [])
            ->assertSessionHasErrors('name');
    }

    public function testCanNotUpdateOtherUsersCategories()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn()
            ->put("/categories/{$category->id}", [
                'name' => 'New Name'
            ])
            ->assertNotFound();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => $category->name
        ]);
    }
}
