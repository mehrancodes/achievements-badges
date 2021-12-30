<?php

namespace App\Achiever\Achievements;

use App\Models\User;

class TwentyLessonsWatched extends AchievementType
{
    public function qualifier(User $user): bool
    {
        return $user->watched()->count() >= 20;
    }

    public function name(): string
    {
        return '20 Lessons Watched';
    }
}

