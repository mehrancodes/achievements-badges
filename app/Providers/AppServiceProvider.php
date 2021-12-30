<?php

namespace App\Providers;

use App\Models\UserAchievement;
use App\Observers\UserAchievementObserver;
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
    }
}