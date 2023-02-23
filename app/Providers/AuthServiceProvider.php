<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Policies\Estimatespolicy;
use App\Policies\Invoicespolicy;
use App\Policies\Rolepolicy;
use App\Policies\Userpolicy;
use App\Policies\Profilepolicy;
use App\Policies\Sellerpolicy;

class AuthServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        $this->registerPolicies();

        Estimatespolicy::estimatesPolicies();
        Invoicespolicy::invoicePolicies();
        Rolepolicy::rolePolicies();
        Userpolicy::userPolicies();
        // Profilepolicy::profilePolicies();
        Sellerpolicy::sellerPolicies();
    }
}
