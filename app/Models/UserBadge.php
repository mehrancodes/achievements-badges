<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserBadge extends Pivot
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }
}
