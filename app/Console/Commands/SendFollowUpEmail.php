<?php

namespace App\Console\Commands;

use App\Mail\FollowUpEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendFollowUpEmail extends Command
{
    protected $signature = 'app:follow-up';

    public function handle()
    {
        $this->info('Processing...');

        User::whereBetween(
            'created_at',
            [
                Carbon::yesterday()->startOfDay(),
                Carbon::yesterday()->endOfDay()
            ]
        )->each(function (User $user) {
            Mail::to($user)->send(new FollowUpEmail);
        });

        $this->info('Done');
    }
}
