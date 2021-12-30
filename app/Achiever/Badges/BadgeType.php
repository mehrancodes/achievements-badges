<?php

namespace App\Achiever\Badges;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

abstract class BadgeType
{
    protected Model $model;

    public function __construct()
    {
        $this->model = Badge::firstOrCreate([
            'name' => $this->name()
        ]);
    }

    abstract public function qualifier(User $user): bool;

    abstract public function name(): string;

    public function modelKey()
    {
        return $this->model->getKey();
    }
}
