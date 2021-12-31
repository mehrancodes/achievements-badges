<?php

namespace App\Achiever\Achievements;

use App\Enums\AchievementsTypeEnum;
use App\Models\User;

class TwentyCommentsWritten extends AchievementType
{
    public function qualifier(User $user): bool
    {
        return $user->comments()->count() >= 20;
    }

    public function name(): string
    {
        return '20 Comments Written';
    }

    public function type(): AchievementsTypeEnum
    {
        return AchievementsTypeEnum::COMMENT();
    }

    public function order(): int
    {
        return 4;
    }
}

