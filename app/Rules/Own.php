<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Own implements Rule
{

    protected $table;

    protected $strip;

    public function __construct($table, $strip = null)
    {
        $this->table = $table;
        $this->strip = $strip;
    }

    public function passes($attribute, $value)
    {
        if ($this->strip) {
            $value = Str::replaceFirst($this->strip, '', $value);
        }

        return DB::table($this->table)
            ->where([
                ['id', '=', $value],
                ['user_id', '=', Auth()->id()]
            ])
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.exists');
    }

}
