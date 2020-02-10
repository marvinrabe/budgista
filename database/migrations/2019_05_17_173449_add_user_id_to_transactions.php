<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTransactions extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->after('id');
        });

        DB::table('transactions')
            ->join('accounts', 'transactions.account_id', '=', 'accounts.id')
            ->select('transactions.id', 'accounts.user_id')
            ->chunkById(100, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('transactions')
                        ->where('id', $row->id)
                        ->update(['user_id' => $row->user_id]);
                }
            });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }
}
