<?php

namespace App\Achiever\Badges;

use App\Models\User;

class MasterBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->achievements()->count() >= $this->requiredAchievements();
    }

    public function name(): string
    {
        return 'Master';
    }

    public function order(): int
    {
        return 3;
    }

    public function requiredAchievements(): int
    {
        return 10;
    }
}

