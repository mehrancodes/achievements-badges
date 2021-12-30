<?php

namespace App\Achiever\Badges;

use App\Models\User;

class AdvancedBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->achievements()->count() >= 8;
    }

    public function name(): string
    {
        return 'Advanced';
    }
}

