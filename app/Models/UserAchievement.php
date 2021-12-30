<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserAchievement extends Pivot
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }
}
