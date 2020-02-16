<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GroupsTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateGroup()
    {
        $this
            ->signIn()
            ->post('/groups', [
                'name' => 'New Group'
            ])
            ->assertRedirect('/budget');

        $this->assertDatabaseHas('groups', [
            'user_id' => Auth::id(),
            'name' => 'New Group'
        ]);
    }

    public function testUpdateGroup()
    {
        $group = factory(Group::class)->create();

        $this
            ->signIn($group->user)
            ->put("/groups/{$group->id}", [
                'name' => 'New Name'
            ])
            ->assertRedirect('/budget');

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => 'New Name'
        ]);
    }

    public function testCollapseGroup()
    {
        $group = factory(Group::class)->create();

        $this
            ->signIn($group->user)
            ->from('/budget/2019-01')
            ->post("/groups/{$group->id}/collapse", [
                'collapsed' => true
            ])
            ->assertRedirect('/budget/2019-01');

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name,
            'collapsed' => true
        ]);
    }

    public function testCanNotUpdateOtherUsersGroups()
    {
        $group = factory(Group::class)->create();

        $this
            ->signIn()
            ->put("/groups/{$group->id}", [
                'name' => 'New Group'
            ])
            ->assertNotFound();

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name
        ]);
    }

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
