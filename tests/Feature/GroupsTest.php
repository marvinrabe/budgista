<?php

namespace Tests\Feature;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GroupsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_groups()
    {
        $ownGroup = factory(Group::class)->create();
        $otherGroup = factory(Group::class)->create();

        $this
            ->signIn($ownGroup->user)
            ->get('/api/groups')
            ->assertJson([
                'data' => [
                    [
                        'id' => $ownGroup->id,
                        'name' => $ownGroup->name
                    ]
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'id' => $otherGroup->id,
                        'name' => $otherGroup->name
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_creates_groups()
    {
        $this->signIn()
            ->post('/api/groups', [
                'name' => 'New Group'
            ]);

        $this->assertDatabaseHas('groups', [
            'user_id' => Auth::id(),
            'name' => 'New Group'
        ]);
    }

    /** @test */
    public function it_deletes_groups()
    {
        $group = factory(Group::class)->create();

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name
        ]);

        $this->signIn($group->user)
            ->delete('/api/groups/' . $group->id);

        $this->assertDatabaseMissing('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name
        ]);
    }

    /** @test */
    public function it_renames_groups()
    {
        $group = factory(Group::class)->create();

        $this->signIn($group->user)
            ->put('/api/groups/' . $group->id, [
                'name' => 'New Name'
            ]);

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => 'New Name'
        ]);
    }

}