<?php

namespace Tests\Feature;

use App\Budget\Month;
use App\Models\Account;
use App\Models\Category;
use App\Models\Group;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CategoriesTest extends TestCase
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

    public function testCreateCategories()
    {
        $this
            ->signIn()
            ->post('/categories', [
                'name' => 'New category'
            ])
            ->assertRedirect('/budget');

        $this->assertDatabaseHas('categories', [
            'user_id' => Auth::id(),
            'name' => 'New category'
        ]);
    }

    public function testCreateCategoriesInGroup()
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

    public function testUpdateCategoryGroup()
    {
        $category = factory(Category::class)->create();

        $group = factory(Group::class)->create([
            'user_id' => $category->user_id
        ]);

        $this
            ->signIn($category->user)
            ->put("/categories/{$category->id}", [
                'group_id' => $group->id,
                'name' => $category->name
            ])
            ->assertRedirect('/budget');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'group_id' => $group->id
        ]);
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

    public function testDeleteCategory()
    {
        $category = factory(Category::class)->create();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => $category->name
        ]);

        $this
            ->signIn($category->user)
            ->delete("/categories/{$category->id}")
            ->assertRedirect('/budget');

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => $category->name
        ]);
    }

    public function testCanNotDeleteOtherUsersCategory()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn()
            ->delete("/categories/{$category->id}")
            ->assertNotFound();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $category->user_id,
            'name' => $category->name
        ]);
    }

    public function testRemoveTransactionRelationshipsOnDelete()
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
            ->delete("/categories/{$category->id}");

        $this->assertNull($transaction->refresh()->category_id);
    }

    public function testTransferTransactionsToNewCategory()
    {
        $this->signIn();

        $categories = factory(Category::class, 2)->create([
            'user_id' => Auth()->id()
        ]);

        $transaction = factory(Transaction::class)->create([
            'category_id' => $categories->first()->id,
            'user_id' => Auth()->id()
        ]);

        $this->delete("/categories/{$categories->first()->id}", [
            'category_id' => $categories->last()->id
        ]);

        $this->assertEquals($categories->last()->id, $transaction->refresh()->category_id);
    }

    public function testOnlyTransfersToUsersCategories()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn($category->user)
            ->delete("/categories/{$category->id}", [
                'category_id' => factory(Category::class)->create()->id
            ])
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id
        ]);
    }

    public function testTransferBudgetsOnDelete()
    {
        $this->signIn();

        $categories = factory(Category::class, 2)->create([
            'user_id' => Auth()->id()
        ]);

        $budget = $categories->first()->budget(Month::current());
        $budget->amount = 12345;
        $budget->save();

        $this
            ->delete("/categories/{$categories->first()->id}", [
                'category_id' => $categories->last()->id
            ]);

        $this->assertEquals(12345, $categories->last()->budget(Month::current())->amount);
    }

}
