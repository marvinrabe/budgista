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
            'icon' => $this->icon,
            'tracking' => $this->tracking,
            'clearedBalance' => $this->clearedBalance(),
            'unclearedBalance' => $this->unclearedBalance(),
            'workingBalance' => $this->workingBalance(),
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
