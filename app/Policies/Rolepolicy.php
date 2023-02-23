<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class Rolepolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }
    public static function rolePolicies(){
        Gate::define('role', function ($user) {
            return $user->hasAccess(['role']);
        });

        Gate::define('role-add', function ($user) {
            return $user->hasAccess(['role-add']);
        });

        Gate::define('role-edit', function ($user) {
            return $user->hasAccess(['role-edit']);
        });

        Gate::define('role-delete', function ($user) {
            return $user->hasAccess(['role-delete']);
        });

        Gate::define('role-permissions', function ($user) {
            return $user->hasAccess(['role-permissions']);
        });
    }
}
