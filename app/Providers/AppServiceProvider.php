<?php

namespace App\Providers;

use App\Models\Recurrence;
use App\Observers\RecurrenceObserver;
use Illuminate\Support\ServiceProvider;

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
        Recurrence::observe(RecurrenceObserver::class);
    }
}
