<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share notifications with all views
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $notifications = auth()->user()->notifications()->latest()->limit(5)->get();
                $unreadNotificationsCount = auth()->user()->unreadNotifications()->count();
                $view->with(compact('notifications', 'unreadNotificationsCount'));
            } else {
                $view->with('notifications', collect(), 'unreadNotificationsCount', 0);
            }
        });
    }
}