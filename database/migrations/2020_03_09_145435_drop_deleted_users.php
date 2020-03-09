<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropDeletedUsers extends Migration
{
    public function up()
    {
        Schema::dropIfExists('deleted_users');
    }
}
