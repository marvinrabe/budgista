<?php

namespace App\Http\Controllers;

use App\Budget;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BudgetController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $budgets = Auth::user()->budgets;

        // load the view and pass the nerds
        return View::make('budgets.index')
            ->with('budgets', $budgets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('budgets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()
                ->route('budgets.create')
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            // store
            $nerd = new Budget;
            $nerd->name = Input::get('name');
            $nerd->user_id = Auth::user()->id;
            $nerd->save();

            // redirect
            Session::flash('message', 'Successfully created budget!');
            return redirect()->route('budgets.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect()->route('sheet', ['budget' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $budget = Budget::find($id);

        // show the edit form and pass the nerd
        return View::make('budgets.edit')
            ->with('budget', $budget);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()
                ->route('budgets.edit', [$id])
                ->withErrors($validator)
                ->withInput(Input::all());
        } else {
            // store
            $nerd = Budget::find($id);
            $nerd->name       = Input::get('name');
            $nerd->save();

            // redirect
            Session::flash('message', 'Successfully updated budget!');
            return redirect()->route('budgets.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        // delete
        $budget = Budget::find($id);
        $budget->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the budget!');
        return redirect()->route('budgets.index');
    }

}
