<?php

namespace App\Achiever\Badges;

use App\Models\User;

class MasterBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->achievements()->count() >= 10;
    }

    public function name(): string
    {
        return 'Master';
    }
}

