<?php


namespace Tests\Feature;

use App\Models\Category;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteGroups()
    {
        $group = factory(Group::class)->create();

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name
        ]);

        $this
            ->signIn($group->user)
            ->delete("/groups/{$group->id}")
            ->assertRedirect('/budget');

        $this->assertDatabaseMissing('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name
        ]);
    }

    public function testDeleteRelatedCategories()
    {
        $group = factory(Group::class)->create();

        $category = factory(Category::class)->create([
            'group_id' => $group->id,
            'user_id' => $group->user_id
        ]);

        $this
            ->signIn($group->user)
            ->delete("/groups/{$group->id}")
            ->assertRedirect('/budget');

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id
        ]);
    }

    public function testIgnoreUnrelatedCategories()
    {
        $group = factory(Group::class)->create();

        $category = factory(Category::class)->create([
            'user_id' => $group->user_id
        ]);

        $this
            ->signIn($group->user)
            ->delete("/groups/{$group->id}")
            ->assertRedirect('/budget');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id
        ]);
    }

    public function testCanNotDeleteOtherUsersGroups()
    {
        $group = factory(Group::class)->create();

        $this
            ->signIn()
            ->delete("/groups/{$group->id}")
            ->assertNotFound();

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name
        ]);
    }
}
