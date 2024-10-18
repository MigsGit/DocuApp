<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
/**
 * Import Interfaces and Repository
 */
use App\Interface\ResourceInterface;
/**
 * Import Job
 */
use App\Jobs\ResourceJob;
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
