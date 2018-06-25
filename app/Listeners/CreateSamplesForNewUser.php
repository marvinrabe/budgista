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

        foreach ($this->availableSamples as $sample => $class) {
            $user->$sample()->saveMany(
                $this->createAll(trans("samples.{$sample}"), $class)
            );
        }

        foreach (trans("samples.accounts") as $accountData) {
            $user->accounts()->save(new Account($accountData));
        }
    }

    /**
     * Returns an array of unsaved classes with specified names.
     *
     * @param array $names Array of names that should be used.
     * @param string $class Class that objects should have
     * @return array Array of unsaved classes with specified names
     */
    protected function createAll(array $names, $class)
    {
        return array_map(function ($name) use ($class) {
            return new $class([
                'name' => $name
            ]);
        }, $names);
    }

}
