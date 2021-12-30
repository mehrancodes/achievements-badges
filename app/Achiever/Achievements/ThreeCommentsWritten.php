<?php

namespace App\Achiever\Achievements;

use App\Models\User;

class ThreeCommentsWritten extends AchievementType
{
    public function qualifier(User $user): bool
    {
        return $user->comments()->count() >= 3;
    }

    public function name(): string
    {
        return '3 Comments Written';
    }
}

