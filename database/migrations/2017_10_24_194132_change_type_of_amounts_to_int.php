<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeOfAmountsToInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('amount')->change();
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->integer('amount')->change();
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
            $table->decimal('amount', 14, 2)->change();
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->decimal('amount', 14, 2)->change();
        });
    }
}
