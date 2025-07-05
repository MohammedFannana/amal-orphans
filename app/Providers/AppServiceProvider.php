<?php

namespace App\Providers;

use App\Models\Orphan;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\DatabaseNotification;

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
    public function boot(): void
    {
        Paginator::useBootstrapFive();

         View::composer('*', function ($view) {

            if (Auth::guard('sponsor')->check()) {
                $unreadSponsorCount = DatabaseNotification::where('notifiable_type', 'App\Models\Sponsor')
                    ->where('notifiable_id', Auth::guard('sponsor')->id())
                    ->whereNull('read_at')
                    ->where('type' , 'App\Notifications\OrphanMessage')
                    ->where('status' , 'active')
                    ->count();


                $unreadCountNotification = auth('sponsor')->user()->unreadNotifications->filter(function ($notification) {
                    return $notification->type === 'App\Notifications\SponsorshipEndingSoon'
                    || $notification->type === 'App\Notifications\SponsorshipEnded';
                })
                ->count();

            }

            elseif(Auth::guard('orphan')->check()) {
                $unreadCountNotification = auth('orphan')->user()->unreadNotifications->filter(function ($notification) {
                    return $notification->type === 'App\Notifications\SponsorshipEndingSoon'
                    || $notification->type === 'App\Notifications\SponsorshipEnded';
                })
                ->count();
                $unreadSponsorCount = 0;

            }

            elseif(Auth::guard('web')->check()){

                $unreadSponsorCount = DatabaseNotification::where(function ($query) {
                        $query->where('notifiable_type', 'App\Models\Sponsor')
                            ->orWhere('notifiable_type', 'App\Models\User');
                    })
                    ->where('notifiable_id', Auth::guard('web')->id())
                    ->whereNull('read_at')
                    ->where('type' , 'App\Notifications\OrphanMessage')
                    ->where('status' , 'active')
                    ->count();

                $unreadCountNotification = auth('web')->user()->unreadNotifications->filter(function ($notification) {
                    return $notification->type === 'App\Notifications\SponsorshipEndingSoon'
                    || $notification->type === 'App\Notifications\SponsorshipEnded';
                })
                ->count();
            }

            elseif(Auth::guard('association')->check()){
                $unreadSponsorCount = DatabaseNotification::whereNull('read_at')
                    ->where('type' , 'App\Notifications\OrphanMessage')
                    ->where('status' , 'inactive')
                    ->count();

                 $unreadCountNotification = auth('association')->user()->unreadNotifications->filter(function ($notification) {
                    return $notification->type === 'App\Notifications\SponsorshipEndingSoon'
                    || $notification->type === 'App\Notifications\SponsorshipEnded';
                })
                ->count();
            }

            else{
                $unreadSponsorCount = 0;
                $unreadCountNotification = 0;
            }


            $view->with('unreadSponsorCount', $unreadSponsorCount)
            ->with('unreadCountNotification' , $unreadCountNotification);
        });

        Gate::define('complete-orphan-data', function ($user, Orphan $orphan) {
            return empty($orphan->guardian_name)
                || empty($orphan->profile->guardian_whats_phone);
        });


    }
}
