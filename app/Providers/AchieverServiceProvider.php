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
use App\Achiever\Achievements\TwentyFiveLessonsWatched;
use App\Achiever\Badges\AdvancedBadge;
use App\Achiever\Badges\BeginnerBadge;
use App\Achiever\Badges\IntermediateBadge;
use App\Achiever\Badges\MasterBadge;
use App\Achiever\Support\AchievementSupport;
use App\Achiever\Support\BadgeSupport;
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
        TwentyFiveLessonsWatched::class,
        FiftyLessonsWatched::class,
    ];

    protected $badges = [
        BeginnerBadge::class,
        IntermediateBadge::class,
        AdvancedBadge::class,
        MasterBadge::class,
    ];

    public function register()
    {
        /**
         * Here we create a new singleton that returns our achievements as a collection
         * It is usable when we want to get the achievements that are qualified by the user.
         */
        $this->app->singleton('achievements', function () {
            return collect($this->achievements)->map(function ($achievement) {
                return new $achievement;
            });
        });

        $this->app->singleton('badges', function () {
            return collect($this->badges)->map(function ($badge) {
                return new $badge;
            });
        });

        /**
         * Support Facades for Achievements and Badges.
         */
        $this->app->bind('achievement_support', function () {
            return new AchievementSupport;
        });

        $this->app->bind('badge_support', function () {
            return new BadgeSupport;
        });
    }
}
