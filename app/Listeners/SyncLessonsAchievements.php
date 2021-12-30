<?php

namespace App\Listeners;

use App\Events\LessonWatched;

class SyncLessonsAchievements
{
    public function handle(LessonWatched $event)
    {
        $user = $event->user;

        // We need to unlock the qualified user achievements first...
        $user->syncAchievements();

        // We sync the badges after the qualified achievements unlocked...
        $user->syncBadges();
    }
}
