<?php

namespace Tests\Feature;

use App\Budget\Month;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CategoriesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_finds_categories()
    {
        $category = factory(Category::class)->create();

        $this->signIn($category->user)
            ->query('category')
            ->setArguments(['id' => $category->id])
            ->setSelectionSet(['id', 'name'])
            ->getData()
            ->assertJsonFragment([
                'data' => [
                    'category' => [
                        'id' => $category->id,
                        'name' => $category->name
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_does_not_find_other_users_categories()
    {
        $category = factory(Category::class)->create();

        $this->signIn()
            ->query('category')
            ->setArguments(['id' => $category->id])
            ->setSelectionSet(['id', 'name'])
            ->getData()
            ->assertJsonFragment([
                'data' => [
                    'category' => null
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    'category' => [
                        'id' => $category->id,
                        'name' => $category->name
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_creates_categories()
    {
        $this->signIn()
            ->mutation('categoryCreate')
            ->setArguments([
                'name' => 'New category'
            ])
            ->setSelectionSet(['name'])
            ->getData()
            ->assertJsonFragment([
                'name' => 'New category'
            ]);

        $this->assertDatabaseHas('categories', [
            'user_id' => Auth::id(),
            'name' => 'New category'
        ]);
    }

    /** @test */
    public function it_renames_categories()
    {
        $category = factory(Category::class)->create();

        $this->signIn($category->user)
            ->mutation('categoryUpdate')
            ->setArguments([
                'id' => $category->id,
                'name' => 'New Name'
            ])
            ->setSelectionSet(['name'])
            ->getData()
            ->assertJsonFragment([
                'name' => 'New Name'
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => 'New Name'
        ]);
    }

    /** @test */
    public function it_can_not_rename_other_users_category()
    {
        $category = factory(Category::class)->create();

        $this->signIn()
            ->mutation('categoryUpdate')
            ->setArguments([
                'id' => $category->id,
                'name' => 'New Name'
            ])
            ->setSelectionSet(['name'])
            ->getData()
            ->assertJsonFragment([
                'categoryUpdate' => null
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => $category->name
        ]);
    }

    /** @test */
    public function it_deletes_categories()
    {
        $category = factory(Category::class)->create();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => $category->name
        ]);

        $this->signIn($category->user)
            ->mutation('categoryDelete')
            ->setArguments([
                'id' => $category->id
            ])
            ->setSelectionSet(['id'])
            ->getData()
            ->assertJsonFragment([
                'id' => $category->id
            ]);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => $category->name
        ]);
    }

    /** @test */
    public function it_can_not_delete_other_users_categories()
    {

        $category = factory(Category::class)->create();

        $this->signIn()
            ->mutation('categoryDelete')
            ->setArguments([
                'id' => $category->id
            ])
            ->setSelectionSet(['id'])
            ->getData()
            ->assertJsonFragment([
                'categoryDelete' => null
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => $category->name
        ]);
    }

    /** @test */
    public function it_sets_existing_transactions_categories_to_null_if_deleted()
    {

        $category = factory(Category::class)->create();

        $transaction = factory(Transaction::class)->create([
            'category_id' => $category->id,
            'account_id' => factory(Account::class)->create([
                'user_id' => $category->user->id
            ])->id
        ]);

        $this
            ->signIn($category->user)
            ->mutation('categoryDelete')
            ->setArguments([
                'id' => $category->id
            ])
            ->setSelectionSet(['id'])
            ->getData()
            ->assertJsonFragment([
                'id' => $category->id
            ]);

        $this->assertNull($transaction->refresh()->category_id);
    }

    /** @test */
    public function it_sets_a_new_category_if_specified_on_deletion()
    {
        $this->signIn();

        $categories = factory(Category::class, 2)->create([
            'user_id' => Auth()->id()
        ]);

        $transaction = factory(Transaction::class)->create([
            'category_id' => $categories->first()->id,
            'user_id' => Auth()->id()
        ]);

        $this
            ->mutation('categoryDelete')
            ->setArguments([
                'id' => $categories->first()->id,
                'transferToCategoryId' => $categories->last()->id
            ])
            ->setSelectionSet(['id'])
            ->getData()
            ->assertJsonFragment([
                'id' => $categories->first()->id
            ]);

        $this->assertEquals($categories->last()->id, $transaction->refresh()->category_id);
    }

    /** @test */
    public function it_sets_only_categories_by_the_user_as_new_category()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn($category->user)
            ->mutation('categoryDelete')
            ->setArguments([
                'id' => $category->id,
                'transferToCategoryId' => factory(Category::class)->create()->id
            ])
            ->setSelectionSet(['id'])
            ->getData()
            ->assertJsonFragment([
                "message" => "Internal server error"
            ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id
        ]);
    }

    /** @test */
    public function it_should_transfer_budgets_to_new_category()
    {
        $this->signIn();

        $categories = factory(Category::class, 2)->create([
            'user_id' => Auth()->id()
        ]);

        $budget = $categories->first()->budget(Month::current());
        $budget->amount = 12345;
        $budget->save();

        $this
            ->mutation('categoryDelete')
            ->setArguments([
                'id' => $categories->first()->id,
                'transferToCategoryId' => $categories->last()->id
            ])
            ->setSelectionSet(['id'])
            ->getData()
            ->assertJsonFragment([
                'id' => $categories->first()->id
            ]);

        $this->assertEquals(12345, $categories->last()->budget(Month::current())->amount);
    }

}
