<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
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
            'email' => $this->email,
            'localization' => [
                'language' => $this->language,
                'locale' => $this->locale,
                'currency' => $this->currency
            ]
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
            'categories' => Category::collection($this->categories),
            'accounts' => Account::collection($this->accounts)
        ];
    }
}
