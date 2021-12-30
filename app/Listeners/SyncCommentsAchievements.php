<?php

namespace App\Listeners;

use App\Events\CommentWritten;

class SyncCommentsAchievements
{
    public function handle(CommentWritten $event)
    {
        $user = $event->comment->user;

        $user->syncAchievements();
    }
}
