<?php

namespace App\Achiever\Badges;

use App\Models\User;

class AdvancedBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->achievements()->count() >= $this->requiredAchievements();
    }

    public function name(): string
    {
        return 'Advanced';
    }

    public function order(): int
    {
        return 2;
    }

    public function requiredAchievements(): int
    {
        return 8;
    }
}

