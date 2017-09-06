<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
            'budget' => 'required'
        ]);

        $budget = Budget::find(Input::get('budget'));
        $this->authorize('update', $budget);

        $account = new Account();
        $account->name = Input::get('name');
        $account->budget_id = $budget->id;
        $account->save();

        return $account;
    }

    public function show(Account $account)
    {
        return $account;
    }

    public function transactions(Account $account)
    {
        $this->authorize('view', $account);

        return $account->transactions()->paginate(25);
    }

    public function update(Request $request, Account $account)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $account->name = Input::get('name');
        $account->save();

        return $account;
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return [];
    }

}
