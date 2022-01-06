<?php

namespace App\Achiever\Support;

use App\Enums\AchievementsTypeEnum;
use App\Models\Achievement as AchievementModel;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Collection;

class BadgeSupport
{
    public function lockedBadges(User $user): Collection
    {
        return $user->badges()
            ->orderBy('order_column')
            ->get();
    }

    public function nextBadge(Badge $currentBadge)
    {
        return app('badges')
            ->map->getModel()
            ->firstWhere('order_column', '>', $currentBadge->order_column);
    }

    public function remainingToUnlockNextBadge($unlockedAchievements, $nextBadge = null): int
    {
        if (is_null($nextBadge)) {
            return 0;
        }

        return $nextBadge->required_achievements - $unlockedAchievements->count();
    }
}
