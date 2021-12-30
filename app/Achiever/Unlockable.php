<?php

namespace App\Achiever;

trait Unlockable
{
    /**
     * Unlock the new achievements for the user.
     */
    public function syncAchievements()
    {
        $achievements = app('achievements')
            ->filter->qualifier($this)
            ->map->modelKey();

        $this->achievements()->sync($achievements);
    }

    /**
     * Unlock the new badges for the user.
     */
    public function syncBadges()
    {
        $badges = app('badges')
            ->filter->qualifier($this)
            ->map->modelKey();

        $this->badges()->sync($badges);
    }
}
