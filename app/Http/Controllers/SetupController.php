<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use MarvinRabe\LaravelIntl\Facades\Currency;

class SetupController extends Controller
{

    public function index()
    {
        return Inertia::render('Setup/Index', [
            'currencies' => Currency::all()
        ]);
    }

    public function postIndex()
    {
        Auth::user()->update(
            request()->validate([
                'currency' => [
                    'required',
                    Rule::in(array_keys(Currency::all()))
                ]
            ])
        );

        return Redirect::to('/setup/categories');
    }

    public function step2()
    {
        return Inertia::render('Setup/Categories', [
            'samples' => trans('samples.categories')
        ]);
    }

    public function postStep2()
    {
        request()->validate([
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer']
        ]);

        $categories = Arr::wrap(request('categories'));

        Collection::make(trans('samples.categories'))
            ->filter(fn($category, $index) => in_array($index, $categories))
            ->each(function ($category) {
                Auth::user()->categories()->create($category);
            });

        return Redirect::to('/setup/accounts');
    }

    public function step3()
    {
        return Inertia::render('Setup/Accounts', []);
    }

    public function postStep3(Request $request)
    {
        $request->validate([
            'accounts' => ['nullable', 'array'],
            'accounts.*.name' => ['nullable', 'string'],
            'accounts.*.amount' => ['nullable', 'integer'],
        ]);

        Collection::make(request('accounts'))
            ->reject(fn($account) => empty($account['name']))
            ->each(function ($data) {
                $account = Auth::user()->accounts()->create($data);

                if (!empty($data['amount'])) {
                    $account->reconcile($data['amount']);
                }
            });

        return Redirect::to('/');
    }

}
