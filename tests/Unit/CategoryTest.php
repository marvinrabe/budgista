<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_be_sorted_automatically()
    {
        $categories = factory(Category::class, 5)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        foreach ($categories as $expectedSort => $category) {
            $this->assertEquals($expectedSort + 1, $category->sort);
        }
    }

}
