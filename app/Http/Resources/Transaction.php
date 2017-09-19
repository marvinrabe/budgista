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
            'account_id' => $this->account->id,
            'category' => $this->category !== null?new Category($this->category):null,
            'amount' => (double) $this->amount,
            'recurring' => (boolean) $this->recurring,
            'rrule' => $this->recurring?$this->rrule->rfcString():null,
            'cleared' => (boolean)$this->cleared,
            'date' => $this->date->toDateString(),
            'created_at' => $this->created_at
        ];
    }
}
