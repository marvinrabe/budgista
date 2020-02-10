<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupToCategory extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->uuid('group_id')->nullable();
            $table->foreign('group_id')
                ->references('id')->on('groups')
                ->onDelete('set null');
        });
    }
}
