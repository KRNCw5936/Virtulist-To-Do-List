<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\TaskList;
use Carbon\Carbon;

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
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
    
                $notifTasks = TaskList::where('user_id', $userId)
                    ->where('is_complete', false)
                    ->whereBetween('end_date', [
                        Carbon::today()->startOfDay(),
                        Carbon::today()->addDays(2)->endOfDay()
                    ])
                    ->get();
    
                $view->with([
                    'notifTasks' => $notifTasks,
                    'notifCount' => $notifTasks->count(),
                ]);
            }
        });
    }
}
