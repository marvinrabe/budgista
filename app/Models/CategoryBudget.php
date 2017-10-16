<?php

namespace App\Models;

use App\Models\Traits\BelongsToUserTrait;
use App\Models\Traits\HasCompositePrimaryKeyTrait;
use Illuminate\Database\Eloquent\Model;

class CategoryBudget extends Model
{

    use BelongsToUserTrait, HasCompositePrimaryKeyTrait;

    public $timestamps = false;

    protected $fillable = ['budget_id', 'category_id', 'month'];

    protected $primaryKey = ['category_id', 'month'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

}
