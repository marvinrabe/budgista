<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnDeleteToForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['account_id']);
            $table->dropForeign(['budget_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('set null');
            $table->foreign('account_id')
                ->references('id')->on('accounts')
                ->onDelete('cascade');
            $table->foreign('budget_id')
                ->references('id')->on('budgets')
                ->onDelete('cascade');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            $table->foreign('budget_id')
                ->references('id')->on('budgets')
                ->onDelete('cascade');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            $table->foreign('budget_id')
                ->references('id')->on('budgets')
                ->onDelete('cascade');
        });

        Schema::table('category_budgets', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            $table->dropForeign(['category_id']);
            $table->foreign('budget_id')
                ->references('id')->on('budgets')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['active_budget_id']);
            $table->foreign('active_budget_id')
                ->references('id')->on('budgets')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['account_id']);
            $table->dropForeign(['budget_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories');
            $table->foreign('account_id')
                ->references('id')->on('accounts');
            $table->foreign('budget_id')
                ->references('id')->on('budgets');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            $table->foreign('budget_id')
                ->references('id')->on('budgets');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            $table->foreign('budget_id')
                ->references('id')->on('budgets');
        });

        Schema::table('category_budgets', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            $table->dropForeign(['category_id']);
            $table->foreign('budget_id')
                ->references('id')->on('budgets');
            $table->foreign('category_id')
                ->references('id')->on('categories');
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                ->references('id')->on('users');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['active_budget_id']);
            $table->foreign('active_budget_id')
                ->references('id')->on('budgets');
        });
    }
}
