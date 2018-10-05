<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\JiraApiClient;

class JiraServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      //Register Jira service class
      $this->app->bind('App\Services\JiraApiClient', function ($app) {
        return new JiraApiClient();
      });
    }
}
