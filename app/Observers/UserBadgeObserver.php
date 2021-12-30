<?php

namespace App\Observers;

use App\Events\BadgeUnlocked;
use App\Models\UserBadge;

class UserBadgeObserver
{
    public function created(UserBadge $userBadge)
    {
        event(new BadgeUnlocked($userBadge->user, $userBadge->badge->name));
    }
}
