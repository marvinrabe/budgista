<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Month;
use Illuminate\Support\Facades\View;

class SheetController extends Controller
{

    public function index(Budget $budget, $month = null)
    {
        $month = $this->getMonth($month);

        return View::make('sheet.index')
            ->with('budget', $budget)
            ->with('month', $month);
    }

    private function getMonth($string)
    {
        try {
            if ($string !== null) {
                return Month::fromString($string);
            }

            return Month::current();
        } catch (\InvalidArgumentException $exception) {
            abort(404);
        }
    }

}
