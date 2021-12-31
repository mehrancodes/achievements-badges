<?php

namespace Tests\Feature\Models;

use App\Achiever\Achievements\FiftyLessonsWatched;
use App\Achiever\Achievements\FirstCommentWritten;
use App\Achiever\Achievements\FirstLessonWatched;
use App\Achiever\Achievements\FiveCommentsWritten;
use App\Achiever\Achievements\FiveLessonsWatched;
use App\Achiever\Achievements\TenCommentsWritten;
use App\Achiever\Achievements\TenLessonsWatched;
use App\Achiever\Achievements\ThreeCommentsWritten;
use App\Achiever\Achievements\TwentyCommentsWritten;
use App\Achiever\Achievements\TwentyFiveLessonsWatched;
use App\Events\AchievementUnlocked;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_achievement_is_earned_when_user_writes_1_comment()
    {
        $mehran = User::factory()->create();

        $john = User::factory()->create();

        $this->addComment($mehran);

        // Assert Mehran gets 1 achievement...
        $this->assertCount(1, $mehran->achievements);

        $this->assertSame($mehran->achievements->first()->name, (new FirstCommentWritten)->name());

        // Assert John only has no achievement...
        $this->assertCount(0, $john->achievements);
    }

    /** @test */
    public function two_achievements_is_earned_when_user_writes_3_comments()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 3);

        $this->assertCount(2, $mehran->achievements);

        $this->assertTrue($mehran->achievements->contains('name', (new ThreeCommentsWritten)->name()));
    }

    /** @test */
    public function three_achievements_is_earned_when_user_writes_5_comments()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 5);

        $this->assertCount(3, $mehran->achievements);

        $this->assertTrue($mehran->achievements->contains('name', (new FiveCommentsWritten)->name()));
    }

    /** @test */
    public function four_achievements_is_earned_when_user_writes_10_comments()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 10);

        $this->assertCount(4, $mehran->achievements);

        $this->assertTrue($mehran->achievements->contains('name', (new TenCommentsWritten)->name()));
    }

    /** @test */
    public function five_achievements_is_earned_when_user_writes_20_comments()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 20);

        $this->assertCount(5, $mehran->achievements);

        $this->assertTrue($mehran->achievements->contains('name', (new TwentyCommentsWritten)->name()));
    }

    /** @test */
    public function an_achievement_is_earned_when_user_watches_1_lesson()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran);

        $this->assertCount(1, $mehran->achievements);

        $this->assertSame($mehran->achievements->first()->name, (new FirstLessonWatched)->name());
    }

    /** @test */
    public function two_achievements_is_earned_when_user_watches_5_lessons()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran, 5);

        $this->assertCount(2, $mehran->achievements);

        $this->assertTrue($mehran->achievements->contains('name', (new FiveLessonsWatched)->name()));
    }

    /** @test */
    public function three_achievements_is_earned_when_user_watches_10_lessons()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran, 10);

        $this->assertCount(3, $mehran->achievements);

        $this->assertTrue($mehran->achievements->contains('name', (new TenLessonsWatched)->name()));
    }

    /** @test */
    public function four_achievements_is_earned_when_user_watches_25_lessons()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran, 25);

        $this->assertCount(4, $mehran->achievements);

        $this->assertTrue($mehran->achievements->contains('name', (new TwentyFiveLessonsWatched)->name()));
    }

    /** @test */
    public function five_achievements_is_earned_when_user_watches_50_lessons()
    {
        $mehran = User::factory()->create();

        $this->watchLesson($mehran, 50);

        $this->assertCount(5, $mehran->achievements);

        $this->assertTrue($mehran->achievements->contains('name', (new FiftyLessonsWatched)->name()));
    }

    /** @test */
    public function it_dispatches_an_event_when_an_achievement_unlocked()
    {
        Event::fake(AchievementUnlocked::class);

        $mehran = User::factory()->create();

        $this->addComment($mehran);

        Event::assertDispatched(AchievementUnlocked::class, function ($event) {
            return $event->achievement_name == (new FirstCommentWritten)->name();
        });
    }
}
