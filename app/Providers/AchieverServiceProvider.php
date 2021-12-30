<?php

namespace App\Providers;

use App\Achiever\Achievements\FiftyLessonsWatched;
use App\Achiever\Achievements\FirstCommentWritten;
use App\Achiever\Achievements\FirstLessonWatched;
use App\Achiever\Achievements\FiveCommentsWritten;
use App\Achiever\Achievements\FiveLessonsWatched;
use App\Achiever\Achievements\TenCommentsWritten;
use App\Achiever\Achievements\TenLessonsWatched;
use App\Achiever\Achievements\ThreeCommentsWritten;
use App\Achiever\Achievements\TwentyCommentsWritten;
use App\Achiever\Achievements\TwentyLessonsWatched;
use Illuminate\Support\ServiceProvider;

class AchieverServiceProvider extends ServiceProvider
{
    protected $achievements = [
        FirstCommentWritten::class,
        ThreeCommentsWritten::class,
        FiveCommentsWritten::class,
        TenCommentsWritten::class,
        TwentyCommentsWritten::class,
        FirstLessonWatched::class,
        FiveLessonsWatched::class,
        TenLessonsWatched::class,
        TwentyLessonsWatched::class,
        FiftyLessonsWatched::class,
    ];

    public function register()
    {
        // Here we create a new singleton that returns our achievements as a collection
        // It is usable when we want to get the achievements that are qualified by the user.
        $this->app->singleton('achievements', function () {
            return collect($this->achievements)->map(function ($achievement) {
                return new $achievement;
            });
        });
    }
}
