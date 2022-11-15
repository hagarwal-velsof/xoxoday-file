<?php

namespace Xoxoday\Fileupload;

use Illuminate\Support\ServiceProvider;

class FileUploadServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
   
    public function boot()
    {
        
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        if ($this->app->runningInConsole()) {
            // Publish assets
            $this->publishes([
              __DIR__.'/config/xofile.php' => config_path('xofile.php'),
            ], 'xofileupload_assets');
          
          }
    }

   
}
