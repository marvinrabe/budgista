<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class BillingController extends Controller
{
    public function index()
    {
        return Inertia::render('Settings/Billing', [
            'product' => config('paddle.product_id')
        ]);
    }
}
