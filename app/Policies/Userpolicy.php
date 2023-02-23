<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class Userpolicy
{
    use HandlesAuthorization;

    public function __construct(){
        //
    }
    public static function userPolicies(){
        Gate::define('user', function ($user) {
            return $user->hasAccess(['user']);
        });

        Gate::define('user-add', function ($user) {
            return $user->hasAccess(['user-add']);
        });

        Gate::define('user-edit', function ($user) {
            return $user->hasAccess(['user-edit']);
        });

        Gate::define('user-delete', function ($user) {
            return $user->hasAccess(['user-delete']);
        });
    }
}
