<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_finds_transaction()
    {
        $transaction = factory(Transaction::class)->create();

        $this->signIn($transaction->user)
            ->query('transaction')
            ->setArguments([
                'id' => $transaction->id
            ])
            ->setSelectionSet(['id', 'amount', 'date'])
            ->getData()
            ->assertJsonFragment([
                'transaction' => [
                    'id' => $transaction->id,
                    'amount' => abs($transaction->amount),
                    'date' => $transaction->date->format('Y-m-d'),
                ]
            ]);
    }

    /** @test */
    public function it_does_not_find_other_users_transaction()
    {
        $transaction = factory(Transaction::class)->create();

        $this->signIn()
            ->query('transaction')
            ->setArguments([
                'id' => $transaction->id
            ])
            ->setSelectionSet(['id', 'amount', 'date'])
            ->getData()
            ->assertJsonFragment([
                'transaction' => null
            ]);
    }

    /** @test */
    public function it_saves_a_transaction_successfully()
    {
        $this->signIn();

        $account = factory(Account::class)->create([
            'user_id' => auth()->id()
        ]);
        $transaction = factory(Transaction::class)->make([
            'account_id' => $account->id
        ]);

        $this
            ->post('/api/transactions', $transaction->toArray())
            ->assertSuccessful();
    }

    /** @test */
    public function it_creates_expenses()
    {
        $account = factory(Account::class)->create();
        $category = factory(Category::class)->create([
            'user_id' => $account->user_id
        ]);

        $this->signIn($account->user);

        $this->mutation(
            'transactionCreate',
            [
                'input' => [
                    'date' => Carbon::now()->format('Y-m-d'),
                    'amount' => 1234,
                    'from' => [
                        'accountId' => $account->id
                    ],
                    'to' => [
                        'payeeName' => 'Acme Co.'
                    ],
                    'categories' => [
                        [
                            'id' => $category->id,
                            'amount' => 1234
                        ]
                    ]
                ]
            ],
            [
                'amount',
                'from' => ['subject' => ['name'], 'cleared'],
                'to' => ['subject' => ['name'], 'cleared'],
                'categories' => ['category' => ['id'], 'amount']
            ]
        )->assertJsonFragment([
            'transactionCreate' => [
                [
                    'amount' => 1234,
                    'from' => [
                        'subject' => ['name' => $account->name],
                        'cleared' => false,
                    ],
                    'to' => [
                        'subject' => ['name' => 'Acme Co.'],
                        'cleared' => true
                    ],
                    'categories' => [
                        [
                            'category' => [
                                'id' => $category->id
                            ],
                            'amount' => 1234
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertDatabaseHas('transactions', [
            'amount' => -1234,
            'account_id' => $account->id,
            'category_id' => $category->id,
            'payee' => 'Acme Co.'
        ]);
    }

    /** @test */
    public function it_creates_income()
    {
        $account = factory(Account::class)->create();

        $this->signIn($account->user);

        $this->mutation(
            'transactionCreate',
            [
                'input' => [
                    'date' => Carbon::now()->format('Y-m-d'),
                    'amount' => 1234,
                    'from' => [
                        'payeeName' => 'Acme Co.'
                    ],
                    'to' => [
                        'accountId' => $account->id
                    ],
                    'categories' => []
                ]
            ],
            [
                'amount',
                'from' => ['subject' => ['name'], 'cleared'],
                'to' => ['subject' => ['name'], 'cleared'],
                'categories' => ['category' => ['id'], 'amount']
            ]
        )->assertJsonFragment([
            'transactionCreate' => [
                [
                    'amount' => 1234,
                    'from' => [
                        'subject' => ['name' => 'Acme Co.'],
                        'cleared' => true
                    ],
                    'to' => [
                        'subject' => ['name' => $account->name],
                        'cleared' => false,
                    ],
                    'categories' => [
                        [
                            'category' => null,
                            'amount' => 1234
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertDatabaseHas('transactions', [
            'amount' => 1234,
            'account_id' => $account->id,
            'payee' => 'Acme Co.'
        ]);
    }

    /** @test */
    public function it_updates_transactions()
    {
        $transaction = factory(Transaction::class)->create();
        $account = factory(Account::class)->create([
            'user_id' => $transaction->user_id
        ]);
        $category = factory(Category::class)->create([
            'user_id' => $transaction->user_id
        ]);

        $this->signIn($transaction->user);

        $this->mutation(
            'transactionUpdate',
            [
                'id' => $transaction->id,
                'input' => [
                    'date' => Carbon::now()->format('Y-m-d'),
                    'amount' => 1234,
                    'from' => [
                        'accountId' => $account->id
                    ],
                    'to' => [
                        'payeeName' => 'Acme Co.'
                    ],
                    'categories' => [
                        [
                            'id' => $category->id,
                            'amount' => 1234
                        ]
                    ]
                ]
            ],
            [
                'id',
                'amount',
                'from' => ['subject' => ['name'], 'cleared'],
                'to' => ['subject' => ['name'], 'cleared'],
                'categories' => ['category' => ['id'], 'amount']
            ]
        )->assertJsonFragment([
            'transactionUpdate' => [
                [
                    'id' => $transaction->id,
                    'amount' => 1234,
                    'from' => [
                        'subject' => ['name' => $account->name],
                        'cleared' => false,
                    ],
                    'to' => [
                        'subject' => ['name' => 'Acme Co.'],
                        'cleared' => true
                    ],
                    'categories' => [
                        [
                            'category' => [
                                'id' => $category->id
                            ],
                            'amount' => 1234
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'amount' => -1234,
            'account_id' => $account->id,
            'category_id' => $category->id,
            'payee' => 'Acme Co.'
        ]);
    }

    /** @test */
    public function it_cant_create_transactions_in_someone_elses_category()
    {
        $this->signIn();

        $account = factory(Account::class)->create([
            'user_id' => auth()->id()
        ]);
        $transaction = factory(Transaction::class)->raw([
            'account_id' => $account->id,
            'category_id' => factory(Category::class)->create()->id,
        ]);

        $this
            ->post('/api/transactions', $transaction)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function it_cant_update_transactions_to_someone_elses_category()
    {
        $this->signIn();

        $account = factory(Account::class)->create([
            'user_id' => auth()->id()
        ]);
        $transaction = factory(Transaction::class)->create([
            'account_id' => $account->id,
            'user_id' => Auth()->id()
        ]);

        $data = $transaction->toArray();
        $data['category_id'] = factory(Category::class)->create()->id;

        $this
            ->put("/api/transactions/{$transaction->id}", $data)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function it_cant_create_transactions_in_someone_elses_account()
    {
        $transaction = factory(Transaction::class)->make();

        $data = $transaction->toArray();
        $data['account_id'] = factory(Account::class)->create()->id;

        $this
            ->signIn()
            ->post('/api/transactions', $data)
            ->assertSessionHasErrors('account_id');
    }

}
