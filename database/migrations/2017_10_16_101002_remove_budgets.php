<?php

use App\Models\Account;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveBudgets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['active_budget_id']);
            $table->dropColumn('active_budget_id');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->dropForeign(['budget_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->dropForeign(['budget_id']);
        });

        Schema::table('category_budgets', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            $table->dropColumn('budget_id');
        });

        // Migrate Data

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('budget_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('budget_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::dropIfExists('budgets');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // There is no way back!
    }
}
