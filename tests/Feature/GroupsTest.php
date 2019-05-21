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

    /** @test */
    public function it_finds_groups()
    {
        $group = factory(Group::class)->create();

        $this->signIn($group->user)
            ->query('group')
            ->setArguments(['id' => $group->id])
            ->setSelectionSet(['id', 'name'])
            ->getData()
            ->assertJsonFragment([
                'data' => [
                    'group' => [
                        'id' => $group->id,
                        'name' => $group->name
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_does_not_find_other_users_groups()
    {
        $group = factory(Group::class)->create();

        $this->signIn()
            ->query('group')
            ->setArguments(['id' => $group->id])
            ->setSelectionSet(['id', 'name'])
            ->getData()
            ->assertJsonFragment([
                'data' => [
                    'group' => null
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    'group' => [
                        'id' => $group->id,
                        'name' => $group->name
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_lists_groups()
    {
        $ownGroup = factory(Group::class)->create();
        $otherGroup = factory(Group::class)->create();

        $this
            ->signIn($ownGroup->user)
            ->query('groups')
            ->setSelectionSet(['id', 'name'])
            ->getData()
            ->assertJson([
                'data' => [
                    'groups' => [
                        [
                            'id' => $ownGroup->id,
                            'name' => $ownGroup->name
                        ]
                    ]
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    'groups' => [
                        [
                            'id' => $otherGroup->id,
                            'name' => $otherGroup->name
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_includes_categories()
    {
        $group = factory(Group::class)->create();
        $category = factory(Category::class)->create([
            'user_id' => $group->user_id,
            'group_id' => $group->id
        ]);

        $this
            ->signIn($group->user)
            ->query('groups')
            ->setSelectionSet([
                'id',
                'categories' => ['id', 'name']
            ])
            ->getData()
            ->assertJson([
                'data' => [
                    'groups' => [
                        [
                            'id' => $group->id,
                            'categories' => [
                                [
                                    'id' => $category->id,
                                    'name' => $category->name
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_creates_groups()
    {
        $this->signIn()
            ->mutation('groupCreate')
            ->setArguments([
                'name' => 'New Group'
            ])
            ->setSelectionSet(['name'])
            ->getData()
            ->assertJsonFragment([
                'name' => 'New Group'
            ]);

        $this->assertDatabaseHas('groups', [
            'user_id' => Auth::id(),
            'name' => 'New Group'
        ]);
    }

    /** @test */
    public function it_renames_groups()
    {
        $group = factory(Group::class)->create();

        $this->signIn($group->user)
            ->mutation('groupUpdate')
            ->setArguments([
                'id' => $group->id,
                'name' => 'New Name'
            ])
            ->setSelectionSet(['name'])
            ->getData()
            ->assertJsonFragment([
                'name' => 'New Name'
            ]);

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => 'New Name'
        ]);
    }

    /** @test */
    public function it_can_not_rename_other_users_group()
    {
        $group = factory(Group::class)->create();

        $this->signIn()
            ->mutation('groupUpdate')
            ->setArguments([
                'id' => $group->id,
                'name' => 'New Name'
            ])
            ->setSelectionSet(['name'])
            ->getData()
            ->assertJsonFragment([
                'groupUpdate' => null
            ]);

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name
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
            ->mutation('groupDelete')
            ->setArguments([
                'id' => $group->id
            ])
            ->setSelectionSet(['id'])
            ->getData()
            ->assertJsonFragment([
                'id' => $group->id
            ]);

        $this->assertDatabaseMissing('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name
        ]);
    }

    /** @test */
    public function it_can_not_delete_other_users_groups()
    {

        $group = factory(Group::class)->create();

        $this->signIn()
            ->mutation('groupDelete')
            ->setArguments([
                'id' => $group->id
            ])
            ->setSelectionSet(['id'])
            ->getData()
            ->assertJsonFragment([
                'groupDelete' => null
            ]);

        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'user_id' => $group->user_id,
            'name' => $group->name
        ]);
    }

    /** @test */
    public function it_shows_null_group_when_category_without_group_is_available()
    {
        $category = factory(Category::class)->create([
            'group_id' => null
        ]);

        $this
            ->signIn($category->user)
            ->query('groups')
            ->setSelectionSet(['id', 'name'])
            ->getData()
            ->assertJsonFragment([
                'data' => [
                    'groups' => [
                        [
                            'id' => null,
                            'name' => 'Ungrouped'
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_null_group_has_largest_sort()
    {
        $category = factory(Category::class)->create([
            'group_id' => null
        ]);
        $group = factory(Group::class)->create([
            'user_id' => $category->user_id
        ]);

        $this
            ->signIn($category->user)
            ->query('groups')
            ->setSelectionSet(['id', 'sort'])
            ->getData()
            ->assertJsonFragment([
                'data' => [
                    'groups' => [
                        [
                            'id' => $group->id,
                            'sort' => $group->sort
                        ],
                        [
                            'id' => null,
                            'sort' => $group->sort + 1
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_sorts_groups()
    {
        $this->signIn();

        $groups = factory(Group::class, 3)->create([
            'user_id' => auth()->id()
        ]);

        $ids = $groups
            ->map(function ($group) {
                return $group->id;
            })
            ->reverse()
            ->values();

        $result = collect($ids)->map(function ($id, $sort) {
            return [
                'id' => $id,
                'sort' => $sort
            ];
        });

        $this->mutation('groupSort')
            ->setArguments([
                'ids' => $ids
            ])
            ->setSelectionSet(['id', 'sort'])
            ->getData()
            ->assertJsonFragment($result[0])
            ->assertJsonFragment($result[1])
            ->assertJsonFragment($result[2]);

    }
}
