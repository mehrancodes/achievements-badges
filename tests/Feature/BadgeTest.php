<?php

namespace Tests\Feature;

use App\Achiever\Badges\AdvancedBadge;
use App\Achiever\Badges\BeginnerBadge;
use App\Achiever\Badges\IntermediateBadge;
use App\Events\BadgeUnlocked;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
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

        $john = User::factory()->create();

        $this->watchLesson($mehran, 25);

        // Assert Mehran gets 2 achievements...
        $this->assertCount(2, $mehran->badges);

        $this->assertTrue($mehran->badges->contains('name', (new IntermediateBadge)->name()));

        // Assert John only has beginner achievement...
        $this->assertCount(1, $john->badges);
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

    /** @test */
    public function it_dispatches_an_event_when_a_badge_unlocked()
    {
        Event::fake(BadgeUnlocked::class);

        $mehran = User::factory()->create();

        $john = User::factory()->create();

        Event::assertDispatched(BadgeUnlocked::class, function ($event) use ($mehran) {
            return $event->badge_name == (new BeginnerBadge)->name()
                && $mehran->id == $event->user->id;
        });
    }
}
