<?php

namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

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
    // public function boot(): void
    // {
    //     config(['app.locale' => 'id']);
	//     Carbon::setLocale('id');
    //     Date::setLocale('id');
    // }
<<<<<<< HEAD

    public function boot(Request $request)
    {
=======
    
    public function boot(Request $request)
    {
        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');
        Date::setLocale('id');

>>>>>>> 72db9305c19a30155324015bdf8458ac32d43068
        if ($request->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }
    }
}