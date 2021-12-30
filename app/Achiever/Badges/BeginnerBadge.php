<?php

namespace App\Achiever\Badges;

use App\Models\User;

class BeginnerBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->achievements()->count() >= 0;
    }

    public function name(): string
    {
        return 'Beginner';
    }
}

