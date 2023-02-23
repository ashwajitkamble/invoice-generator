<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class Profilepolicy
{
    use HandlesAuthorization;

    public function __construct(){
        
    }

    public static function profilePolicies(){
            
        Gate::define('profile', function ($user) {
            return $user->hasAccess(['profile']);
        });
    }
}
