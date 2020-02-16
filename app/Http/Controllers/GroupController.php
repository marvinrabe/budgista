<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Group as GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GroupController extends Controller
{

    public function create()
    {
        return Inertia::render('Groups/Create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Group::class);

        Auth::user()->groups()->create(
            $request->validate([
                'name' => 'required'
            ])
        );

        return Redirect::route('budget');
    }

    public function edit(Group $group)
    {
        $this->authorize('view', $group);

        return Inertia::render('Groups/Edit', [
            'group' => $group
        ]);
    }

    public function update(Request $request, Group $group)
    {
        $this->authorize('update', $group);

        $group->update(
            $request->validate([
                'name' => ['required', 'string']
            ])
        );

        return Redirect::route('budget');
    }

    public function collapse(Request $request, Group $group)
    {
        $this->authorize('update', $group);

        $group->update(
            $request->validate([
                'collapsed' => ['required', 'boolean']
            ])
        );

        return Redirect::back();
    }

    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);

        $group->delete();

        return Redirect::route('budget');
    }

    public function sort(Request $request)
    {
        $request->validate([
            'groups' => 'required'
        ]);

        $sorting = array_flip(request('groups'));

        foreach (Auth::user()->groups as $group) {
            $group->sort = $sorting[$group->id];
            $group->save();
        }

        return Redirect::back();
    }

}
