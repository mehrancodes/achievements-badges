<?php

namespace App\Http\Controllers;

use App\Achiever\Facades\Achievement;
use App\Achiever\Facades\Badge;
use App\Models\User;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        list($achievements, $nextAchievements) = $this->achievementsData($user);

        list($currentBadge, $nextBadge) = $this->badgesData($user);

        return response()->json([
            'unlocked_achievements' => Achievement::getAchievementsName($achievements),
            'next_available_achievements' => Achievement::getAchievementsName($nextAchievements),
            'current_badge' => $currentBadge->name ?? null,
            'next_badge' => $nextBadge->name ?? null,
            'remaining_to_unlock_next_badge' => Badge::remainingToUnlockNextBadge($achievements, $nextBadge),
        ]);
    }

    protected function badgesData(User $user): array
    {
        $lockedBadges = Badge::lockedBadges($user);

        $currentBadge = $lockedBadges->last();

        $nextBadge = Badge::nextBadge($currentBadge);

        return [$currentBadge, $nextBadge];
    }

    protected function achievementsData(User $user): array
    {
        $achievements = $user->achievements;

        $nextAchievements = Achievement::nextAvailableAchievements($achievements);

        return array($achievements, $nextAchievements);
    }
}
