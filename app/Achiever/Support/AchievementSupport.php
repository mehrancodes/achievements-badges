<?php

namespace App\Achiever\Support;

use App\Enums\AchievementsTypeEnum;
use App\Models\Achievement as AchievementModel;
use Illuminate\Support\Collection;

class AchievementSupport
{
    public function nextAvailableAchievements(Collection $achievements): Collection
    {
        $locked = $this->getLockedAchievements($achievements);

        $collect = collect([
            $this->firstAchievementByType($locked, AchievementsTypeEnum::LESSON()),
            $this->firstAchievementByType($locked, AchievementsTypeEnum::COMMENT()),
        ]);

        // Sort the collection by order_column and remove null items as well...
        return $collect->sortBy('order_column')->filter();
    }

    public function getLockedAchievements(Collection $achievements): Collection
    {
        return app('achievements')
            ->filter(function ($achievement) use ($achievements) {
                return $achievements
                    ->doesntContain('name', $achievement->name());
            })
            ->map->getModel();
    }

    public function firstAchievementByType(Collection $locked, AchievementsTypeEnum $type): ?AchievementModel
    {
        return $locked->first(function ($achievement) use ($type) {
            return $achievement->type->isEqual($type);
        });
    }

    public function getAchievementsName($unlockedAchievements): array
    {
        return $unlockedAchievements->pluck('name')->toArray();
    }
}
