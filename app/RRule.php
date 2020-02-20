<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class RRule extends \RRule\RRule implements Arrayable
{

    public static function fromRequest($request)
    {
        return new static([
            'FREQ' => $request['frequency'],
            'INTERVAL' => $request['interval']
        ]);
    }

    public function interval()
    {
        return $this->interval ?? 1;
    }

    public function frequency()
    {
        $frequencies = array_flip(static::$frequencies);

        if (!$this->freq || !isset($frequencies[$this->freq])) {
            return 'MONTHLY';
        }

        return $frequencies[$this->freq];
    }

    public function toArray()
    {
        return [
            'frequency' => $this->frequency(),
            'interval' => $this->interval()
        ];
    }
}
