<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account as AccountResource;
use App\Http\Resources\Transaction as TransactionResource;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Account::class);
    }

    public function index()
    {
        return AccountResource::collection(Auth::user()->accounts()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $account = new Account();
        $account->name = request('name');

        Auth::user()->accounts()->save($account);

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
        $request->validate([
            'name' => 'required'
        ]);

        $account->name = request('name');
        $account->save();

        return new AccountResource($account);
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return [];
    }

}
