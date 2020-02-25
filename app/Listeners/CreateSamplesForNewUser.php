<?php

namespace App\Listeners;

use App\Account;
use App\Category;
use App\User;
use Illuminate\Auth\Events\Registered;

class CreateSamplesForNewUser
{

    protected $availableSamples = [
        'categories' => Category::class
    ];

    /**
     * Create sample content for newly registered users.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle($event)
    {
        /**
         * @var User $user
         */
        $user = $event->user;

        foreach (trans("samples.categories") as $categoryName) {
            $user->categories()->create([
                'name' => $categoryName
            ]);
        }

        foreach (trans("samples.accounts") as $accountData) {
            $user->accounts()->create($accountData);
        }
    }

}
