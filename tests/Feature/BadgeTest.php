<?php

namespace Tests\Feature;

use App\Achiever\Badges\AdvancedBadge;
use App\Achiever\Badges\BeginnerBadge;
use App\Achiever\Badges\IntermediateBadge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function new_users_get_beginner_badge()
    {
        $mehran = User::factory()->create();

        $this->assertCount(1, $mehran->badges);

        $this->assertTrue($mehran->badges->contains('name', (new BeginnerBadge)->name()));
    }

    /** @test */
    public function intermediate_badge_is_earned_when_user_earns_4_achievements()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran, 25);

        $this->assertCount(2, $mehran->badges);

        $this->assertTrue($mehran->badges->contains('name', (new IntermediateBadge)->name()));
    }

    /** @test */
    public function advanced_badge_is_earned_when_user_earns_8_achievements()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran, 50);

        $this->addComment($mehran, 5);

        $this->assertCount(3, $mehran->badges);

        $this->assertTrue($mehran->badges->contains('name', (new AdvancedBadge)->name()));
    }
}
