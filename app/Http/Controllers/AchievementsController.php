<?php

namespace App\Http\Controllers;

use App\Achiever\Facades\Achievement;
use App\Achiever\Facades\Badge;
use App\Models\Badge as BadgeModel;
use App\Models\User;

class AchievementsController extends Controller
{
    public function __invoke(User $user)
    {
        $achievements = $user->achievements;

        $nextAchievements = Achievement::nextAvailableAchievements($achievements);

        $currentBadge = $this->getCurrentBadge($user);

        $nextBadge = Badge::nextBadge($currentBadge);

        return response()->json([
            'unlocked_achievements' => Achievement::getAchievementsName($achievements),
            'next_available_achievements' => Achievement::getAchievementsName($nextAchievements),
            'current_badge' => $currentBadge->name ?? null,
            'next_badge' => $nextBadge->name ?? null,
            'remaining_to_unlock_next_badge' => Badge::remainingToUnlockNextBadge($achievements, $nextBadge),
        ]);
    }

    protected function getCurrentBadge(User $user): ?BadgeModel
    {
        $lockedBadges = Badge::lockedBadges($user);

        return $lockedBadges->last();
    }
}
