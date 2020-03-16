<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaddleToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('subscription_state')->default('trial');
            $table->date('subscription_ends_at')->nullable();
            $table->string('paddle_cancel_url')->nullable();
            $table->string('paddle_update_url')->nullable();
        });
    }
}
