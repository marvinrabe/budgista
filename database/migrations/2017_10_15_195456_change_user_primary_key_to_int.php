<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserPrimaryKeyToInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'old_user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->renameColumn('id', 'old_id');
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->increments('id');
            //$table->primary('id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn('old_user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
        });

        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->index()->nullable();
        });

        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->index()->nullable();
        });
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
