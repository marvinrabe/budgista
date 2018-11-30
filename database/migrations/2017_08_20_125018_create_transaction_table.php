<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('account_id');
            $table->uuid('category_id')->nullable();
            $table->string('payee');
            $table->integer('amount');
            $table->boolean('cleared')->default(false);
            $table->date('date');
            $table->boolean('recurring')->default(false);
            $table->text('rrule')->nullable();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('set null');
            $table->foreign('account_id')
                ->references('id')->on('accounts')
                ->onDelete('cascade');
            $table->index(['account_id', 'date', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
