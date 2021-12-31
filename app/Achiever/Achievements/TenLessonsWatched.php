<?php

namespace App\Achiever\Achievements;

use App\Enums\AchievementsTypeEnum;
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

    public function type(): AchievementsTypeEnum
    {
        return AchievementsTypeEnum::LESSON();
    }

    public function order(): int
    {
        return 7;
    }
}

