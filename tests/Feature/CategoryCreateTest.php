<?php

namespace Tests\Feature;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CategoryCreateTest extends TestCase
{
    use RefreshDatabase;

    public function testPreselectGroup()
    {
        $group = factory(Group::class)->create();

        $response = $this
            ->signIn($group->user)
            ->get("/categories/create?group={$group->id}");

        $response->assertHasProp('group');
        $this->assertEquals($group->id, $response->props()['group']['id']);
    }

    public function testStoreCategory()
    {
        $group = factory(Group::class)->create();

        $this
            ->signIn($group->user)
            ->post('/categories', [
                'name' => 'New category',
                'group_id' => $group->id
            ])
            ->assertRedirect('/budget');

        $this->assertDatabaseHas('categories', [
            'user_id' => Auth::id(),
            'name' => 'New category',
            'group_id' => $group->id
        ]);
    }

    public function testRequireName()
    {
        $group = factory(Group::class)->create();

        $this
            ->signIn($group->user)
            ->post('/categories', [
                'group_id' => $group->id
            ])
            ->assertSessionHasErrors('name');
    }

    public function testRequireGroup()
    {
        $this
            ->signIn()
            ->post('/categories', [
                'name' => 'My Category'
            ])
            ->assertSessionHasErrors('group_id');
    }
}
