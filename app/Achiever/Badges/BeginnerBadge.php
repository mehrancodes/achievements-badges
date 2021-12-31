<?php

namespace App\Achiever\Badges;

use App\Models\User;

class BeginnerBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->achievements()->count() >= $this->requiredAchievements();
    }

    public function name(): string
    {
        return 'Beginner';
    }

    public function order(): int
    {
        return 0;
    }

    public function requiredAchievements(): int
    {
        return 0;
    }
}

