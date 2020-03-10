<?php

namespace App\Console\Commands;

use App\Transaction;
use App\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessRecurringTransactions extends Command
{
    protected $signature = 'app:process-recurring';

    public function handle()
    {
        $this->info('Processing...');

        Transaction::withoutGlobalScope(UserScope::class)
            ->with('related')
            ->where('date', '<=', Carbon::now())
            ->where('recurring', '=', true)
            ->cursor()
            ->each(function(Transaction $transaction) {
                $transaction->processRecurring();

                $this->info('Transaction: '.$transaction->id);
            });

        $this->info('Done');
    }
}
