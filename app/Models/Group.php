<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use App\Models\Traits\HasUuidKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;

class Group extends Model
{
    use HasUuidKey,
        BelongsToUser;

    public $timestamps = false;

    protected $appends = [
        'links'
    ];

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
            $builder->orderBy('sort');
        });

        static::creating(function (Group $model) {
            $model->determineSort();
        });
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function getLinksAttribute()
    {
        return [
            'edit' => URL::route('groups.edit', $this),
            'update' => URL::route('groups.update', $this),
            'destroy' => URL::route('groups.destroy', $this),
            'collapse' => URL::route('groups.collapse', $this),
            'categories' => [
                'create' => URL::route('categories.create', ['group' => $this])
            ]
        ];
    }

    /**
     * Sets sort to highest available + 1
     */
    public function determineSort()
    {
        $this->sort = $this->where('user_id', '=', $this->user_id)->max('sort') + 1;
    }
}
