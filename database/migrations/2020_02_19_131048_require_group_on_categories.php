<?php

use App\Models\User;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RequireGroupOnCategories extends Migration
{
    public function up()
    {
        User::whereHas('categories', function (Builder $query) {
            $query->withoutGlobalScope(UserScope::class);
            $query->whereNull('group_id');
        })->each(function ($user) {
            $groupName = trans('action.ungrouped', [], $user->language);
            $group = $user->groups()->create([
                'name' => $groupName
            ]);
            $user->categories()
                ->withoutGlobalScope(UserScope::class)
                ->whereNull('group_id')
                ->update(['group_id' => $group->id]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->foreign('group_id')
                ->references('id')->on('groups')
                ->onDelete('cascade');
        });
    }
}
