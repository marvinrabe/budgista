<?php

namespace App\Http\Controllers;

use App\Month;
use App\Category;
use App\ViewModels\Budget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Money\Converter;
use Money\Exchange\FixedExchange;
use Money\Money;
use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Parser\IntlLocalizedDecimalParser;


class BudgetController extends Controller
{
    public function index($month = null)
    {
        /*$currencies = new ISOCurrencies();

        $numberFormatter = new \NumberFormatter('de_DE', \NumberFormatter::DECIMAL);
        $moneyParser = new IntlLocalizedDecimalParser($numberFormatter, $currencies);

        $yen = $moneyParser->parse('1.000,00', new Currency('JPY'));

        $exchange = new FixedExchange([
            'EUR' => [
                'JPY' => 132.41
            ],
            'JPY' => [
                'EUR' => 0.0083956007
            ]
        ]);

        $converter = new Converter(new ISOCurrencies(), $exchange);

        $eur = $converter->convert($yen, new Currency('EUR'));

        ddd($eur->getAmount());}*/

        $month = $this->getMonth($month);

        return Inertia::render('Budget/Index', [
            'budget' => (new Budget($month))->toArray()
        ]);
    }

    public function uncategorized($month)
    {
        $month = $this->getMonth($month);

        return Inertia::render('Budget/Uncategorized', [
            'budget' => (new Budget($month))->toArray(),
            'transactions' => Auth::user()
                ->transactions()
                ->noTransfers()
                ->inMonth($month)
                ->whereNull('category_id')
                ->with(['account', 'targetAccount'])
                ->orderBy('date', 'desc')
                ->paginate(25),
        ]);
    }

    public function show($month, Category $category)
    {
        $month = $this->getMonth($month);

        $category->load([
            'budgets' => fn($query) => $query->where('month', $month),
            'budgets.upcomingTransactions'
        ]);

        return Inertia::render('Budget/Show', [
            'budget' => (new Budget($month))->toArray(),
            'category' => $category,
            'categoryBudget' => $category->budget($month)->append([
                'previousMonth', 'activity', 'available', 'recommendedBudget'
            ]),
            'transactions' => $category
                ->transactions()
                ->whereBetween('date', [
                    $month->firstDay(),
                    $month->lastDay()
                ])
                ->with(['account', 'targetAccount'])
                ->orderBy('date', 'desc')
                ->paginate(25),
        ]);
    }

    public function store($month, Category $category)
    {
        $month = $this->getMonth($month);

        $this->authorize('update', $category);

        $category
            ->budget($month)
            ->fill(
                request()->validate([
                    'amount' => 'required'
                ])
            )
            ->save();

        return Redirect::back();
    }

    private function getMonth($string): Month
    {
        try {
            return Month::fromString($string);
        } catch (\InvalidArgumentException $exception) {
            abort(404);
        }
    }

}
