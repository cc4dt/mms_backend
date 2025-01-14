<?php

namespace App\Providers;

use App\Models\Team;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::after(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });
        
        Gate::define('open-ticket', function ($user) {
            return $user->isSupervisor() or $user->isAdmin() or $user->isClient();
        });
        
        Gate::define('assign-ticket', function ($user) {
            return $user->isSupervisor() or $user->isAdmin();
        });
        
        Gate::define('close-ticket', function ($user, $ticket) {
            return $user->isSupervisor() or $user->isAdmin() or ($user->isTeamleader() and $user->id == $ticket->teamleader_id);
        });
        
        Gate::define('view-reports', function ($user) {
            return $user->isSupervisor() or $user->isDealer() or $user->isAdmin();
        });
    }
}
