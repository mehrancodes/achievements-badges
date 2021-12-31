<?php

namespace App\Achiever\Badges;

use App\Models\User;

class IntermediateBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->achievements()->count() >= $this->requiredAchievements();
    }

    public function name(): string
    {
        return 'Intermediate';
    }

    public function order(): int
    {
        return 1;
    }

    public function requiredAchievements(): int
    {
        return 4;
    }
}

