<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use RRule\RRule;

class ProcessRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurring:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process due recurring transactions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Processing...');

        $transactions = Transaction::where('date', '<=', Carbon::now())->where('recurring', '=', true)->cursor();

        foreach ($transactions as $transaction) {

            /**
             * @var RRule $rrule
             */
            $occurences = $transaction->rrule->getOccurrences(2);

            /**
             * @var Transaction $transaction
             */
            $newTransaction = $transaction->replicate(['id', 'date', 'cleared']);
            $newTransaction->date = $occurences[1];
            $newTransaction->cleared = false;

            $transaction->rrule = null;

            DB::transaction(function () use ($transaction, $newTransaction) {
                $newTransaction->save();
                $transaction->save();
            });

            $this->info('Transaction: ' . $transaction->id);
        }

        $this->info('Done');
    }
}
