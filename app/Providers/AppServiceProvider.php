<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use NascentAfrica\Jetstrap\JetstrapFacade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!request()->isJson()) {

            // use Core Ui presets
            JetstrapFacade::useCoreUi3();

            // It is also important to point out that Laravel 8 still includes pagination views built
            // using Bootstrap CSS. To use these views instead of the default Tailwind views
            Paginator::useBootstrap();
        }

        // Image base64 validator custom rules
        Validator::extend('image_base64', 'App\Validators\Base64Validator@validate');
        Validator::replacer('image_base64', 'App\Validators\Base64Validator@message');

        // Older than validator custom rules
        Validator::extend('older_then', 'App\Validators\AgeValidator@validate');
        Validator::replacer('older_then', 'App\Validators\AgeValidator@message');

        // Country validator custom rules
        Validator::extend('country', 'App\Validators\CountryValidator@validate');
    }
}
