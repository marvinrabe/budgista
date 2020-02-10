<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeletedUsersTable extends Migration
{
    public function up()
    {
        Schema::create('deleted_users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created_at', 0)->nullable();
            $table->timestamp('deleted_at', 0)->nullable();
            $table->text('feedback')->nullable();
        });
    }
}
