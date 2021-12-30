<?php

namespace App\Achiever\Achievements;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

abstract class AchievementType
{
    /**
     * Achievement's related model record
     * @var Achievement
     */
    protected Achievement $model;

    public function __construct()
    {
        // Get or create the Achievement model
        // We use this property to identify the Achievement model.
        $this->model = Achievement::firstOrCreate([
            'name' => $this->name()
        ]);
    }

    /**
     * Qualify if the user can unlock the achievement.
     *
     * @param User $user
     * @return bool
     */
    abstract public function qualifier(User $user): bool;

    /**
     * Get the human-readable achievement name.
     *
     * @return string
     */
    abstract public function name(): string;

    /**
     * Get the achievement model ID.
     *
     * @return mixed
     */
    public function modelKey()
    {
        return $this->model->getKey();
    }
}
