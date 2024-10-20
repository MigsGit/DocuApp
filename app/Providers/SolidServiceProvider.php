<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
/**
 * Import Interfaces
 */
use App\Interfaces\ResourceInterface;
use App\Interfaces\EdocsInterface;
/**
 * Import Job
 */
use App\Jobs\ResourceJob;
use App\Jobs\EdocsJob;

class SolidServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ResourceInterface::class, ResourceJob::class);
        $this->app->bind(EdocsInterface::class, EdocsJob::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
