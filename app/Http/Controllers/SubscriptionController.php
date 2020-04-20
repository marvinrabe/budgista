<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SubscriptionController extends Controller
{
    public function index()
    {
        return Inertia::render('Settings/Subscription', [
            'product' => config('paddle.product_id')
        ]);
    }
}
