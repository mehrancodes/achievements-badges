<?php

namespace App\Achiever\Achievements;

use App\Models\User;

class TenCommentsWritten extends AchievementType
{
    public function qualifier(User $user): bool
    {
        return $user->comments()->count() >= 10;
    }

    public function name(): string
    {
        return '10 Comments Written';
    }
}

