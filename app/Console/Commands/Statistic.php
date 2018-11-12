<?php

namespace App\Console\Commands;

use App\Models\DeletedUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Statistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:statistic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prints user statistics.';

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
        $this->info('Users: '. User::count());
        $this->info('Active Users: '. User::where('last_login_at', '>=', Carbon::now()->subDays(30))->count());
        $this->info('New Users last 14 days: '. User::where('created_at', '>=', Carbon::now()->subDays(14))->count());
        $this->info('Deleted Users: '. DeletedUser::count());
    }
}