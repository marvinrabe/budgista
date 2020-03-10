<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelatedIdToTransactions extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('related_id')->after('category_id')->nullable();
            $table->foreign('related_id')
                ->references('id')->on('transactions')
                ->onDelete('cascade');
        });
    }
}
