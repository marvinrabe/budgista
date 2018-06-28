<?php

namespace App\Listeners;

use App\Models\Account;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class CreateSamplesForNewUser
{

    protected $availableSamples = [
        'categories' => Category::class
    ];

    /**
     * Create sample content for newly registered users.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle($event)
    {
        /**
         * @var User $user
         */
        $user = $event->user;

        foreach (trans("samples.categories") as $groupName => $categories) {
            $group = $user->groups()->create([
                'name' => $groupName
            ]);

            foreach($categories as $categoryName) {
                $category = $user->categories()->make([
                    'name' => $categoryName
                ]);
                $category->group_id = $group->id;
                $category->save();
            }
        }

        foreach (trans("samples.accounts") as $accountData) {
            $user->accounts()->save(new Account($accountData));
        }
    }

}
