<?php

namespace App\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App\Models\Scopes\BudgetTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use UuidModelTrait, BudgetTrait;

}