<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use App\Models\Traits\HasUuidKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Group extends Model
{
    use HasUuidKey,
        BelongsToUser;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sort',
        'collapsed'
    ];

    protected $with = ['categories'];

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

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Sets sort to highest available + 1
     */
    public function determineSort()
    {
        $this->sort = $this->where('user_id', '=', $this->user_id)->max('sort') + 1;
    }
}
