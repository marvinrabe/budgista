<?php

namespace App\Http\Controllers;

use App\Account;
use App\Category;
use App\Transaction;
use App\Rules\Own;
use App\ViewModels\TransactionForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laracasts\Flash\Flash;

class TransactionController extends Controller
{

    public function index()
    {
        return Inertia::render('Transactions/Index', [
            'netWorth' => Auth::user()
                ->transactions()
                ->current()
                ->sum('amount'),
            'transactions' => Auth::user()
                ->transactions()
                ->current()
                ->with(['category', 'account', 'targetAccount'])
                ->orderBy('date', 'desc')
                ->paginate(25),
        ]);
    }

    public function create(Request $request)
    {
        $transaction = Transaction::make([
            'account_id' => $request->get('account', null),
            'category_id' => $request->get('category', null),
            'date' => Carbon::now()
        ]);

        return Inertia::render('Transactions/Create', new TransactionForm($transaction));
    }

    public function store(Request $request)
    {
        $isTransfer = Str::startsWith($request->get('category_id'), 'account:');

        $request->validate([
            'payee' => $isTransfer ? 'nullable' : 'required',
            'account_id' => [
                'required',
                new Own('accounts')
            ],
            'category_id' => $isTransfer ? [
                new Own('accounts', 'account:')
            ] : [
                'nullable',
                new Own('categories')
            ],
            'amount' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string']
        ]);

        $transaction = Transaction::make(
            $request->only(['payee', 'account_id', 'amount', 'date', 'notes'])
        );

        if ($request->has('recurrence')) {
            $transaction->recurrence = $request->get('recurrence');
        } else {
            $transaction->recurrence = null;
        }

        if ($isTransfer) {
            $payee = $request->get('payee');
            if (empty($payee)) {
                $transaction->payee = trans('action.transfer');
            }
            $transaction->save();
            $transaction->createRelated(
                Str::replaceFirst('account:', '', $request->get('category_id'))
            );
        } else {
            $transaction->category_id = $request->get('category_id');
            $transaction->save();
        }


        Flash::success(__('Transaction saved.'));

        $referer = request('referer');
        if ($this->validReferer($referer)) {
            return Redirect::to($referer);
        }

        return Redirect::route('accounts.show', [$transaction->account]);
    }

    protected function validReferer($referer)
    {
        if (empty($referer)) {
            return false;
        }
        if (!Str::startsWith($referer, '/')) {
            return false;
        }
        $routes = Route::getRoutes();
        $request = Request::create($referer);
        try {
            $result = $routes->match($request);
            return true;
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return false;
        }
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return Inertia::render('Transactions/Edit', new TransactionForm($transaction));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $isTransfer = Str::startsWith($request->get('category_id'), 'account:');

        $request->validate([
            'payee' => $isTransfer ? 'nullable' : 'required',
            'account_id' => [
                'required',
                new Own('accounts')
            ],
            'category_id' => $isTransfer ? [
                new Own('accounts', 'account:')
            ] : [
                'nullable',
                new Own('categories')
            ],
            'amount' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string']
        ]);

        $transaction = $transaction->fill(
            $request->only(['payee', 'account_id', 'amount', 'date', 'notes'])
        );

        if ($request->has('recurrence')) {
            $transaction->recurrence = $request->get('recurrence');
        } else {
            $transaction->recurrence = null;
        }

        if ($isTransfer) {
            $payee = $request->get('payee');
            if (empty($payee)) {
                $transaction->payee = trans('action.transfer');
            }
            $transaction->save();
            $transaction->createRelated(
                Str::replaceFirst('account:', '', $request->get('category_id'))
            );
        } else {
            $transaction->category_id = $request->get('category_id');
            $transaction->save();
        }

        Flash::success(__('Transaction saved.'));

        return Redirect::route('accounts.show', [$transaction->account]);
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        Flash::success(__('Transaction deleted.'));

        return Redirect::route('accounts.show', [$transaction->account]);
    }

}
