<?php

namespace App\Providers;

use App\Models\Membership;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        View::composer(['layouts.partials.sidebar', 'layouts.partials.topbar'], function ($view) {
            $pendingMembershipCount = 0;

            if (Auth::check()) {
                $user = Auth::user();

                if ($user->isOfficer() && $user->managedOrganization) {
                    $pendingMembershipCount = Membership::where('organization_id', $user->managedOrganization->id)
                        ->pending()
                        ->count();
                } elseif ($user->isSuperAdmin()) {
                    $pendingMembershipCount = Membership::pending()->count();
                }
            }

            $view->with('pendingMembershipCount', $pendingMembershipCount);
        });
    }
}
