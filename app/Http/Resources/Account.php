<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Account extends Resource
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
            'name' => $this->name,
            'clearedBalance' => (int)$this->clearedBalance(),
            'unclearedBalance' => (int)$this->unclearedBalance(),
            'workingBalance' => (int)$this->workingBalance(),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'links' => [
                'transactions' => route('accounts.transactions', ['id' => $this->id])
            ]
        ];
    }

}
