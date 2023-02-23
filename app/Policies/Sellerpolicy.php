<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class Sellerpolicy
{
    use HandlesAuthorization;
    public function __construct()
    {
        //
    }
    public static function sellerPolicies(){
        Gate::define('seller', function ($user) {
            return $user->hasAccess(['seller']);
        });

        Gate::define('seller-add', function ($user) {
            return $user->hasAccess(['seller-add']);
        });

        Gate::define('seller-edit', function ($user) {
            return $user->hasAccess(['seller-edit']);
        });

        Gate::define('seller-delete', function ($user) {
            return $user->hasAccess(['seller-delete']);
        });
    }
}
