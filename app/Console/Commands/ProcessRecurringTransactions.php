<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessRecurringTransactions extends Command
{
    protected $signature = 'app:process-recurring';

    public function handle()
    {
        $this->info('Processing...');

        $transactions = Transaction::withoutGlobalScope(UserScope::class)
            ->where('date', '<=', Carbon::now())
            ->where('recurring', '=', true)
            ->cursor();

        foreach ($transactions as $transaction) {
            $transaction->processRecurring();

            $this->info('Transaction: '.$transaction->id);
        }

        $this->info('Done');
    }
}
