<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        // Unlock the Beginner badge for the user...
        $user->syncBadges();
    }
}
