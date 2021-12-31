<?php

namespace App\Achiever\Achievements;

use App\Enums\AchievementsTypeEnum;
use App\Models\Achievement;
use App\Models\User;

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
            'name' => $this->name(),
            'type' => $this->type(),
            'order_column' => $this->order(),
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
     * Get the achievement type.
     *
     * @return AchievementsTypeEnum
     */
    abstract public function type(): AchievementsTypeEnum;

    /**
     * Get the achievement order number.
     *
     * @return int
     */
    abstract public function order(): int;

    /**
     * Get the achievement model.
     *
     * @return Achievement
     */
    public function getModel(): Achievement
    {
        return $this->model;
    }

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
