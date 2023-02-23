<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class Invoicespolicy
{
    use HandlesAuthorization;

    public function __construct(){
        //
    }

    public static function invoicePolicies(){
        Gate::define('invoice', function ($user) {
            return $user->hasAccess(['invoice']);
        });

        Gate::define('invoice-add', function ($user) {
            return $user->hasAccess(['invoice-add']);
        });

        Gate::define('invoice-edit', function ($user) {
            return $user->hasAccess(['invoice-edit']);
        });

        Gate::define('invoice-delete', function ($user) {
            return $user->hasAccess(['invoice-delete']);
        });
    }
}
