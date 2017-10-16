<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Month;
use Auth;

class UserController extends Controller
{

    public function show()
    {
        return new UserResource(Auth::user());
    }

    public function month($month = null)
    {
        $month = $this->getMonth($month);

        return [
            'data' => Auth::user()->month($month),
            'links' => [
                'prev' => route('budgets.month', ['month' => $month->previous()]),
                'next' => route('budgets.month', ['month' => $month->next()])
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
