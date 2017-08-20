<?php

namespace App;

use App\Models\Scopes\BudgetTrait;
use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\UuidModelTrait;

class Account extends Model
{

    use UuidModelTrait, BudgetTrait;

}
