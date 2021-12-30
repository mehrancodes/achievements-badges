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
}
