<?php

namespace Tests\Feature;

use App\Month;
use App\Account;
use App\Category;
use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryDeleteTest extends TestCase
{

    use RefreshDatabase;

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
            ->post("/categories/{$category->id}/delete")
            ->assertRedirect('/categories');

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
            ->post("/categories/{$category->id}/delete")
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
            ->post("/categories/{$category->id}/delete");

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

        $this->post("/categories/{$categories->first()->id}/delete", [
            'category_id' => $categories->last()->id
        ]);

        $this->assertEquals($categories->last()->id, $transaction->refresh()->category_id);
    }

    public function testOnlyTransfersToUsersCategories()
    {
        $category = factory(Category::class)->create();

        $this
            ->signIn($category->user)
            ->post("/categories/{$category->id}/delete", [
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
            ->post("/categories/{$categories->first()->id}/delete", [
                'category_id' => $categories->last()->id
            ]);

        $this->assertEquals(12345, $categories->last()->budget(Month::current())->amount);
    }
}
