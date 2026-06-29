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
        // symfony/console 7.4 empurra comandos do core para o caminho "lazy" (ContainerCommandLoader),
        // onde o Laravel 12.19 não injeta a aplicação no comando, causando "make() on null" no console.
        // Garantimos a injeção em toda resolução de comando via container.
        $this->app->resolving(\Illuminate\Console\Command::class, function ($command) {
            $command->setLaravel($this->app);
        });

        Recurrence::observe(RecurrenceObserver::class);
    }
}
