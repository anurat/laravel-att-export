<?php

namespace Anurat\AttExport;

use Illuminate\Support\ServiceProvider;

class AttExportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('attExport', function ($app) {
            return new AttExport();
        });
    }

    public function boot()
    {
    }
}
