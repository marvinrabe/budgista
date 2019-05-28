<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'app:process-recurring';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Process due recurring transactions';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $this->info('Processing...');

        $transactions = Transaction::withoutGlobalScope(UserScope::class)
            ->where('date', '<=', Carbon::now())
            ->where('recurring', '=', true)
            ->cursor();

        foreach ($transactions as $transaction) {
            Transaction::processRecurring($transaction);

            $this->info('Transaction: '.$transaction->id);
        }

        $this->info('Done');
    }
}
