<?php

namespace App\Http\Controllers;

use App\Enums\AchievementsTypeEnum;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Collection;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $unlockedAchievements = $user->achievements;

        $lockedBadges = $this->lockedBadges($user);

        $currentBadge = $lockedBadges->last();

        $nextBadge = $this->nextBadge($currentBadge);

        $remaining = $this->remainingToUnlockNextBadge($nextBadge, $unlockedAchievements);

        return response()->json([
            'unlocked_achievements' => $unlockedAchievements->pluck('name')->toArray(),
            'next_available_achievements' => $this->nextLockedLessons($unlockedAchievements),
            'current_badge' => $currentBadge->name ?? null,
            'next_badge' => $nextBadge->name ?? null,
            'remaining_to_unlock_next_badge' => $remaining,
        ]);
    }

    protected function nextLockedLessons(Collection $unlockedAchievements): array
    {
        $locked = $this->lockedAchievements($unlockedAchievements);

        // return empty array if no locked achievement left...
        if ($locked->isEmpty()) {
            return [];
        }

        $collect = collect([
            $locked->first(function ($achievement) {
                return $achievement->type->isEqual(AchievementsTypeEnum::LESSON());
            }),
            $locked->first(function ($achievement) {
                return $achievement->type->isEqual(AchievementsTypeEnum::COMMENT());
            })
        ]);

        $sorted = $collect->sortBy('order_column');

        return $sorted->pluck('name')->toArray();
    }

    protected function lockedBadges(User $user): Collection
    {
        return $user->badges()->orderBy('order_column')->get();
    }

    protected function nextBadge(Badge $currentBadge)
    {
        $badge = app('badges')
            ->map->getModel()
            ->firstWhere('order_column', '>', $currentBadge->order_column);

        return $badge;
    }

    protected function remainingToUnlockNextBadge($nextBadge, $unlockedAchievements)
    {
        if (is_null($nextBadge)) {
            return 0;
        }

        return $nextBadge->required_achievements - $unlockedAchievements->count();
    }

    /**
     * Return all achievements that are lock yet.
     */
    protected function lockedAchievements(Collection $unlockedAchievements)
    {
        return app('achievements')
            ->filter(function ($achievement) use ($unlockedAchievements) {
                return !in_array($achievement->name(), $unlockedAchievements->pluck('name')->toArray());
            })
            ->map->getModel();
    }
}
