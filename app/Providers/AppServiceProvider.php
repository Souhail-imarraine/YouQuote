<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;
use App\Models\Quote;
use App\Models\User;
use PhpParser\Node\Expr\PostDec;

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

        Gate::define('is_admin', function(User $user){
            return $user->role === 'Admin';
        });
        
        Gate::define('afficher_quote', function(User $user, Quote $quotes){
            return $user->id  !== $quotes->user_id;
        });

    }
}
