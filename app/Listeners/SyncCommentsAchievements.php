<?php

namespace App\Listeners;

use App\Events\CommentWritten;

class SyncCommentsAchievements
{
    public function handle(CommentWritten $event)
    {
        $user = $event->comment->user;

        // We need to unlock the qualified user achievements first...
        $user->syncAchievements();

        // We sync the badges after the qualified achievements unlocked...
        $user->syncBadges();
    }
}
