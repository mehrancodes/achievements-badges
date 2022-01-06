<?php

namespace App\Achiever\Facades;

use App\Models\Badge as BadgeModel;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method remainingToUnlockNextBadge(Collection $unlockedAchievements, BadgeModel $nextBadge)
 * @method lockedBadges(User $user)
 * @method nextBadge(BadgeModel $currentBadge)
 */
class Badge extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'badge_support';
    }
}
