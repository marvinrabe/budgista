<?php

namespace App\ViewModels;

use App\Transaction;
use Illuminate\Support\Facades\URL;
use Spatie\ViewModels\ViewModel;

class TransactionForm extends ViewModel
{
    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function transaction()
    {
        return [
            'recurring' => $this->transaction->recurring,
            'amount' => $this->transaction->amount,
            'recurrence' => optional($this->transaction->recurrence)->toArray(),
            'payee' => $this->transaction->payee,
            'notes' => $this->transaction->notes,
            'category_id' => $this->transaction->related
                ? 'account:'.$this->transaction->related->account_id
                : $this->transaction->category_id,
            'account_id' => $this->transaction->account_id,
            'date' => $this->transaction->date->format('Y-m-d')
        ];
    }

    public function links()
    {
        if ($this->transaction->exists) {
            return [
                'update' => URL::route('transactions.update', $this->transaction),
                'destroy' => URL::route('transactions.destroy', $this->transaction)
            ];
        }
        return [
            'store' => URL::route('transactions.store')
        ];
    }

    public function referer()
    {
        return request()->get('referer');
    }
}
