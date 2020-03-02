<?php

use App\Month;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{

    protected $categories = [
        0 => 0.08,
        1 => 0.06,
        2 => 0.05,
        3 => 0.14,
        4 => 0.06,
        5 => 0.25,
        6 => 0.11,
        7 => 0.1,
        8 => 0.05,
        9 => 0.02,
        10 => 0.08
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\User::class)->create([
            'email' => 'developer@budgista.com',
            'language' => 'en',
            'locale' => 'en',
            'currency' => 'USD',
            'email_verified_at' => now()
        ]);

        event(new \Illuminate\Auth\Events\Registered($user));

        Auth::setUser($user);

        $thisMonth = CarbonImmutable::now()->firstOfMonth();
        $months = Collection::make([$thisMonth]);
        for ($i = 1; $i <= 11; $i++) {
            $months->prepend($thisMonth->subMonths($i));
        }

        $months->each(function (CarbonImmutable $month) use ($user, $thisMonth) {
            $income = $this->randomize(254983);

            factory(\App\Transaction::class)->create([
                'user_id' => $user->id,
                'date' => $month,
                'account_id' => $user->accounts[2]->id,
                'payee' => 'Income',
                'amount' => $income // Based on US avg. monthly income
            ]);

            $cashPercent = 0.2;
            $cash = $cashPercent * $income;
            $this->transfer($cash, $user->accounts[2], $user->accounts[0], $month);

            $creditPercent = 0.7;
            $creditcard = $creditPercent * $income;
            $this->transfer($creditcard, $user->accounts[2], $user->accounts[1], $month);

            $expense = (int) ($income * (1 + rand(-10, -5) / 100));

            $budget = $this->expenses($expense, $user, $month,
                [$cashPercent, $creditPercent, (1 - $cashPercent - $creditPercent)]);
            $left = $income - $budget;

            $aBudget = rand(0, $left);
            $bBudget = $this->randomize($left - $aBudget);

            $user->categories[11]
                ->budget(Month::fromString($month->format('Y-m')))
                ->update([
                    'amount' => $aBudget
                ]);

            $user->categories[12]
                ->budget(Month::fromString($month->format('Y-m')))
                ->update([
                    'amount' => $bBudget
                ]);


        });
    }

    public function expenses($expense, $user, CarbonImmutable $month, $accountShare)
    {
        $budgetSum = 0;
        foreach ($user->categories as $key => $category) {
            if (!isset($this->categories[$key])) {
                continue;
            }

            $part = $expense * $this->categories[$key];

            $lift = 1;
            if (\Carbon\Carbon::now()->format('Y-m') == $month->format('Y-m')) {
                $lift = 0.3;
            }

            factory(\App\Transaction::class)->create([
                'user_id' => $user->id,
                'category_id' => $user->categories[$key]->id,
                'date' => $month,
                'account_id' => $user->accounts[0]->id,
                'amount' => (int) (-$part * $lift * $accountShare[0])
            ]);

            factory(\App\Transaction::class)->create([
                'user_id' => $user->id,
                'category_id' => $user->categories[$key]->id,
                'date' => $month,
                'account_id' => $user->accounts[1]->id,
                'amount' => (int) (-$part * $lift * $accountShare[1])
            ]);

            factory(\App\Transaction::class)->create([
                'user_id' => $user->id,
                'category_id' => $user->categories[$key]->id,
                'date' => $month,
                'account_id' => $user->accounts[2]->id,
                'amount' => (int) (-$part * $lift * $accountShare[2])
            ]);

            $budget = (int) (round($part / 100) * 100);
            $category
                ->budget(Month::fromString($month->format('Y-m')))
                ->update([
                    'amount' => (round($part / 100) * 100)
                ]);
            $budgetSum += $budget;
        }
        return $budgetSum;
    }

    public function transfer($amount, $a, $b, $month)
    {
        factory(\App\Transaction::class)->create([
            'user_id' => $a->user_id,
            'date' => $month,
            'account_id' => $a->id,
            'payee' => 'Transfer',
            'amount' => (int) -$amount
        ]);

        factory(\App\Transaction::class)->create([
            'user_id' => $b->user_id,
            'date' => $month,
            'account_id' => $b->id,
            'payee' => 'Transfer',
            'amount' => (int) $amount
        ]);
    }

    public function randomize($value)
    {
        return (int) ($value * (1 + rand(-10, 10) / 100));
    }
}
