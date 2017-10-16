<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Month;
use Auth;

class MonthController extends Controller
{

    public function show($month = null)
    {
        $month = $this->getMonth($month);

        return [
            'data' => Auth::user()->month($month),
            'links' => [
                'prev' => route('month', ['month' => $month->previous()]),
                'next' => route('month', ['month' => $month->next()])
            ]
        ];
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
