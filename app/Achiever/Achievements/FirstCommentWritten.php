<?php

namespace App\Achiever\Achievements;

use App\Enums\AchievementsTypeEnum;
use App\Models\User;

class FirstCommentWritten extends AchievementType
{
    public function qualifier(User $user): bool
    {
        return $user->comments()->count() >= 1;
    }

    public function name(): string
    {
        return 'First Comment Written';
    }

    public function type(): AchievementsTypeEnum
    {
        return AchievementsTypeEnum::COMMENT();
    }

    public function order(): int
    {
        return 0;
    }
}

