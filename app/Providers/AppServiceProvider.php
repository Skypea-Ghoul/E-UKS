<?php

namespace App\Providers;

use App\Models\Riwayat;
use App\Models\User;
use App\Observers\RiwayatObserver;
use App\Policies\UserPolicy;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Riwayat::observe(RiwayatObserver::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
