<?php

namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
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

    public function boot(Request $request)
    {
        if ($request->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }
    }
    
}