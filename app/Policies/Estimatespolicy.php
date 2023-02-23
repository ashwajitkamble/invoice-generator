<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class Estimatespolicy
{
    use HandlesAuthorization;

    public function __construct(){

    }

    public static function estimatesPolicies(){
        Gate::define('estimate', function ($user) {
            return $user->hasAccess(['estimate']);
        });

        Gate::define('estimate-add', function ($user) {
            return $user->hasAccess(['estimate-add']);
        });

        Gate::define('estimate-edit', function ($user) {
            return $user->hasAccess(['estimate-edit']);
        });

        Gate::define('estimate-delete', function ($user) {
            return $user->hasAccess(['estimate-delete']);
        });
    }
}
