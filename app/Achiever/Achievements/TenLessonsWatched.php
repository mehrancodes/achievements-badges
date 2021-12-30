<?php

namespace App\Achiever\Achievements;

use App\Models\User;

class TenLessonsWatched extends AchievementType
{
    public function qualifier(User $user): bool
    {
        return $user->watched()->count() >= 10;
    }

    public function name(): string
    {
        return '10 Lessons Watched';
    }
}

