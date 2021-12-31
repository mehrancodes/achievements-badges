<?php

namespace App\Achiever\Achievements;

use App\Enums\AchievementsTypeEnum;
use App\Models\User;

class FiftyLessonsWatched extends AchievementType
{
    public function qualifier(User $user): bool
    {
        return $user->watched()->count() >= 50;
    }

    public function name(): string
    {
        return '50 Lessons Watched';
    }

    public function type(): AchievementsTypeEnum
    {
        return AchievementsTypeEnum::LESSON();
    }

    public function order(): int
    {
        return 9;
    }
}

