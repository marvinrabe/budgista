<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeletedUser extends Model
{

    protected $fillable = [
        'created_at',
        'feedback'
    ];

    protected function updateTimestamps()
    {
        if (!$this->exists) {
            $this->deleted_at = $this->freshTimestamp();
        }
    }

}
