<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Traits\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    use UuidModelTrait,
        BelongsToUserTrait;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sort',
        'collapsed'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->orderBy('sort', 'asc');
        });

        static::creating(function (Group $model) {
            $model->determineSort();
        });
    }

    /**
     * Sets sort to highest available + 1
     */
    public function determineSort()
    {
        $this->sort = $this->where('user_id', '=', $this->user_id)->max('sort') + 1;
    }

}
