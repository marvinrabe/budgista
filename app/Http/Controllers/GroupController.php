<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Group as GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function index()
    {
        return GroupResource::collection(Auth::user()->groups);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Group::class);

        $group = Auth::user()->groups()->create(
            $request->validate([
                'name' => 'required'
            ])
        );

        return new GroupResource($group);
    }

    public function show(Group $group)
    {
        $this->authorize('view', $group);

        return new GroupResource($group);
    }

    public function update(Request $request, Group $group)
    {
        $this->authorize('update', $group);

        $group->update(
            $request->validate([
                'name' => 'required'
            ])
        );

        return new GroupResource($group);
    }

    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);

        $group->delete();

        return [];
    }
}
