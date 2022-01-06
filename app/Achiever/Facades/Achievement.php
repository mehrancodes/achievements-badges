<?php

namespace App\Achiever\Facades;

use App\Enums\AchievementsTypeEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method nextAvailableAchievements(Collection $achievements)
 * @method getLockedAchievements(Collection $achievements)
 * @method firstAchievementByType(Collection $locked, AchievementsTypeEnum $type)
 * @method getAchievementsName($unlockedAchievements)
 */
class Achievement extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'achievement_support';
    }
}
