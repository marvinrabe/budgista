<?php

namespace App;

class RRule extends \RRule\RRule
{

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

}
