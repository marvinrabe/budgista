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
            'clearedBalance' => (double) $this->clearedBalance(),
            'unclearedBalance' => (double) $this->unclearedBalance(),
            'workingBalance' => (double) $this->workingBalance(),
        ];
    }
}
