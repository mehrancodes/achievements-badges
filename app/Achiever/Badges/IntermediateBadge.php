<?php

namespace App\Achiever\Badges;

use App\Models\User;

class IntermediateBadge extends BadgeType
{
    public function qualifier(User $user): bool
    {
        return $user->achievements()->count() >= 4;
    }

    public function name(): string
    {
        return 'Intermediate';
    }
}

