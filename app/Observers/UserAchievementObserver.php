<?php

namespace App\Observers;

use App\Events\AchievementUnlocked;
use App\Models\UserAchievement;

class UserAchievementObserver
{
    public function created(UserAchievement $userAchievement)
    {
        event(new AchievementUnlocked($userAchievement->user, $userAchievement->achievement->name));
    }
}
