<?php

namespace App\Http\Controllers;

use App\Account;
use App\Category;
use App\Transaction;
use App\Rules\Own;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laracasts\Flash\Flash;

class TransactionController extends Controller
{

    public function create(Request $request)
    {
        $this->authorize('create', Transaction::class);

        return Inertia::render('Transactions/Create', [
            'account' => $request->has('account')
                ? Account::find($request->get('account'))
                : null,
            'category' => $request->has('category')
                ? Category::find($request->get('category'))
                : null,
            'referer' => $request->get('referer')
        ]);
    }

    public function store()
    {
        $this->authorize('create', Transaction::class);

        $transaction = Transaction::make(
            request()->validate([
                'payee' => 'required',
                'account_id' => [
                    'required',
                    new Own('accounts')
                ],
                'category_id' => [
                    'nullable',
                    new Own('categories')
                ],
                'amount' => 'required|integer',
                'date' => 'required',
                'notes' => ['nullable', 'string']
            ])
        );

        if (!empty(request('recurrence'))) {
            $transaction->recurrence = request('recurrence');
        }

        $transaction->save();

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

        return Inertia::render('Transactions/Edit', [
            'transaction' => $transaction
        ]);
    }

    public function update(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        if (!empty(request('recurrence'))) {
            $transaction->recurrence = request('recurrence');
        } else {
            $transaction->recurrence = null;
        }

        $transaction->update(
            request()->validate([
                'payee' => 'required',
                'amount' => 'required|integer',
                'date' => 'required|date',
                'account_id' => [
                    'required',
                    new Own('accounts')
                ],
                'category_id' => [
                    'nullable',
                    new Own('categories')
                ],
                'notes' => ['nullable', 'string']
            ])
        );

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

    public function clear(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->update([
            'cleared' => !$transaction->cleared
        ]);

        return Redirect::back();
    }

}
