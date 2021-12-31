<?php

namespace App\Http\Controllers;

use App\Enums\AchievementsTypeEnum;
use App\Models\Achievement;
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

        $remaining = $this->remainingToUnlockNextBadge($unlockedAchievements, $nextBadge);

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

        $collect = collect([
            $this->firstAchievementByType($locked, AchievementsTypeEnum::LESSON()),
            $this->firstAchievementByType($locked, AchievementsTypeEnum::COMMENT()),
        ]);

        // Sort the collection by order_column and remove null items as well...
        $sorted = $collect->sortBy('order_column')
            ->filter();

        return $sorted->pluck('name')
            ->toArray();
    }

    protected function lockedAchievements(Collection $unlockedAchievements): Collection
    {
        return app('achievements')
            ->filter(function ($achievement) use ($unlockedAchievements) {
                $names = $unlockedAchievements->pluck('name')->toArray();

                return !in_array($achievement->name(), $names);
            })
            ->map->getModel();
    }

    protected function firstAchievementByType(Collection $locked, AchievementsTypeEnum $type): ?Achievement
    {
        return $locked->first(function ($achievement) use ($type) {
            return $achievement->type->isEqual($type);
        });
    }

    protected function lockedBadges(User $user): Collection
    {
        return $user->badges()
            ->orderBy('order_column')
            ->get();
    }

    protected function nextBadge(Badge $currentBadge)
    {
        return app('badges')
            ->map->getModel()
            ->firstWhere('order_column', '>', $currentBadge->order_column);
    }

    protected function remainingToUnlockNextBadge($unlockedAchievements, $nextBadge = null): int
    {
        if (is_null($nextBadge)) {
            return 0;
        }

        return $nextBadge->required_achievements - $unlockedAchievements->count();
    }
}
