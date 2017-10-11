<?php

namespace App\AutoBudget;

use App\Models\Category;

class AutoBudget
{

    public static function forCategory($category_id)
    {
        $category = Category::find($category_id);

        $forecast = new Forecast($category->budget);

        return $forecast->forCategory($category);
    }

}
