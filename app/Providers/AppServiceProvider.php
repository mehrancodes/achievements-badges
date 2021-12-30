<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserBadge;
use App\Observers\UserAchievementObserver;
use App\Observers\UserBadgeObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

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
        UserAchievement::observe(UserAchievementObserver::class);
        UserBadge::observe(UserBadgeObserver::class);
        User::observe(UserObserver::class);
    }
}
