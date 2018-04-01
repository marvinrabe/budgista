<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Category as CategoryResource;

class Transaction extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'payee' => $this->payee,
            'account_id' => $this->account_id,
            'category_id' => $this->category_id,
            'amount' => $this->amount,
            'recurring' => $this->recurring,
            'rrule' => $this->recurring ? $this->rrule->rfcString() : null,
            'cleared' => $this->cleared,
            'date' => $this->date->toDateString(),
            'created_at' => $this->created_at
        ];
    }
}
