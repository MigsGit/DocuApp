<?php

namespace App\Providers;
use App\Jobs\FileJob;
use App\Jobs\EdocsJob;
use App\Jobs\ResourceJob;
use App\Interfaces\FileInterface;
use App\Interfaces\EdocsInterface;
use App\Interfaces\ResourceInterface;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(FileInterface::class, FileJob::class);
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
