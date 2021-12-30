<?php

namespace App\Listeners;

use App\Events\LessonWatched;

class SyncLessonsAchievements
{
    public function handle(LessonWatched $event)
    {
        $event->user->syncAchievements();
    }
}
