<?php

namespace App\Console\Commands;

use App\Auth\EmailTokenRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Clean extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'app:clean';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Cleans up database.';

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

        DB::table('budgets')->where('amount', '=', 0)->delete();
        resolve(EmailTokenRepository::class)->deleteExpired();

        $this->info('Done');
    }
}
