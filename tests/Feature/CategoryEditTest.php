<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryEditTest extends TestCase
{

    use RefreshDatabase;

    public function testUpdateCategory()
    {
        $category = factory(Category::class)->create();

        $group = factory(Group::class)->create([
            'user_id' => $category->user_id
        ]);

        $this
            ->signIn($category->user)
            ->put("/categories/{$category->id}", [
                'group_id' => $group->id,
                'name' => 'New Name'
            ])
            ->assertRedirect('/budget');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'group_id' => $group->id,
            'name' => 'New Name'
        ]);
    }

    public function testRequireName()
    {
        $category = factory(Category::class)->create();

        $group = factory(Group::class)->create([
            'user_id' => $category->user_id
        ]);

        $this
            ->signIn($category->user)
            ->put("/categories/{$category->id}", [
                'group_id' => $group->id,
            ])
            ->assertSessionHasErrors('name');
    }

    public function testRequireGroup()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn($category->user)
            ->put("/categories/{$category->id}", [
                'name' => 'New Name'
            ])
            ->assertSessionHasErrors('group_id');
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
