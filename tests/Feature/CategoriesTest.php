<?php

namespace Tests\Feature;

use App\Budget\Month;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function it_doesnt_need_a_new_category_for_deletion()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn($category->user)
            ->delete("/api/categories/{$category->id}", [
                'category_id' => ''
            ])
            ->assertSuccessful();

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id
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
            ->delete("/api/categories/{$category->id}", []);

        $this->assertNull($transaction->refresh()->category_id);
    }

    /** @test */
    public function it_only_deletes_transactions_from_the_right_owner()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn()
            ->delete("/api/categories/{$category->id}", [])
            ->assertStatus(404);
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
            'account_id' => factory(Account::class)->create([
                'user_id' => Auth()->id()
            ])->id
        ]);

        $this
            ->delete("/api/categories/{$categories->first()->id}", [
                'category_id' => $categories->last()->id
            ])
            ->assertSuccessful();

        $this->assertEquals($categories->last()->id, $transaction->refresh()->category_id);
    }

    /** @test */
    public function it_sets_only_categories_by_the_user_as_new_category()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn($category->user)
            ->delete("/api/categories/{$category->id}", [
                'category_id' => factory(Category::class)->create()->id
            ])
            ->assertSessionHasErrors('category_id');
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

        $response = $this
            ->delete("/api/categories/{$categories->first()->id}", [
                'category_id' => $categories->last()->id
            ])
            ->assertSuccessful();

        $this->assertEquals(12345, $categories->last()->budget(Month::current())->amount);
    }

}
