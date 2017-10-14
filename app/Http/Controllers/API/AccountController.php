<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account as AccountResource;
use App\Http\Resources\Transaction as TransactionResource;
use App\Models\Account;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Account::class);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'budget_id' => 'required'
        ]);

        $budget = Budget::find(Input::get('budget_id'));
        $this->authorize('update', $budget);

        $account = new Account();
        $account->name = Input::get('name');
        $account->budget_id = $budget->id;
        $account->save();

        return new AccountResource($account);
    }

    public function show(Account $account)
    {
        return new AccountResource($account);
    }

    public function transactions(Account $account)
    {
        $this->authorize('view', $account);

        return TransactionResource::collection($account->transactions()->with(['category', 'account'])->orderBy('date', 'desc')->paginate(25));
    }

    public function update(Request $request, Account $account)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $account->name = Input::get('name');
        $account->save();

        return new AccountResource($account);
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return [];
    }

}
