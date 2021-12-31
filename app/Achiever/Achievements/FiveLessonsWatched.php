<?php

namespace App\Achiever\Achievements;

use App\Enums\AchievementsTypeEnum;
use App\Models\User;

class FiveLessonsWatched extends AchievementType
{
    public function qualifier(User $user): bool
    {
        return $user->watched()->count() >= 5;
    }

    public function name(): string
    {
        return '5 Lessons Watched';
    }

    public function type(): AchievementsTypeEnum
    {
        return AchievementsTypeEnum::LESSON();
    }

    public function order(): int
    {
        return 6;
    }
}

