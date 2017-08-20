<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryBudgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_budgets', function (Blueprint $table) {
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('month', 7);
            $table->decimal('amount', 14, 2)->default(0);
            $table->uuid('budget_id');
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->primary(['category_id', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_budgets');
    }
}
