<?php

namespace Tests\Feature;

use App\Achiever\Achievements\FiftyLessonsWatched;
use App\Achiever\Achievements\FirstCommentWritten;
use App\Achiever\Achievements\FirstLessonWatched;
use App\Achiever\Achievements\FiveCommentsWritten;
use App\Achiever\Achievements\FiveLessonsWatched;
use App\Achiever\Achievements\TenLessonsWatched;
use App\Achiever\Achievements\ThreeCommentsWritten;
use App\Achiever\Achievements\TwentyCommentsWritten;
use App\Achiever\Badges\AdvancedBadge;
use App\Achiever\Badges\IntermediateBadge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AchievementsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_retrieve_user_achievements_status()
    {
        // Given we have a user with 4 achievements and 2 badges...
        $mehran = User::factory()->create();

        $this->addComment($mehran, 3);

        $this->watchLesson($mehran, 5);

        $res = $this->get(route('users.achievements.index', $mehran))
            ->assertOk();

        // Assert all the properties get filled correctly...
        $res->assertJson([
            'unlocked_achievements' => [
                (new FirstCommentWritten)->name(),
                (new ThreeCommentsWritten)->name(),
                (new FirstLessonWatched)->name(),
                (new FiveLessonsWatched)->name(),
            ]
        ]);

        $res->assertJson([
            'next_available_achievements' => [
                (new FiveCommentsWritten)->name(),
                (new TenLessonsWatched)->name(),
            ]
        ]);

        $remainingToNextBadge = (new AdvancedBadge)->requiredAchievements() - $mehran->achievements->count();

        $res->assertJson([
            'current_badge' => (new IntermediateBadge)->name(),
            'next_badge' => (new AdvancedBadge)->name(),
            'remaining_to_unlock_next_badge' => $remainingToNextBadge,
        ]);
    }

    /** @test */
    public function unlocked_achievements_returns_empty_array_if_no_achievement_unlocked()
    {
        $mehran = User::factory()->create();

        $this->get(route('users.achievements.index', $mehran))
            ->assertOk()
            ->assertJson([
                'unlocked_achievements' => [],
                'next_available_achievements' => [
                    (new FirstCommentWritten)->name(),
                    (new FirstLessonWatched)->name(),
                ]
            ]);
    }

    /** @test */
    public function next_available_achievements_returns_empty_array_if_all_achievements_unlocked()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 20);

        $this->watchLesson($mehran, 50);

        // Also assert the next badge is null as well as remaining...
        $this->get(route('users.achievements.index', $mehran))
            ->assertOk()
            ->assertJsonFragment([
                'next_available_achievements' => [],
                'next_badge' => null,
                'remaining_to_unlock_next_badge' => 0
            ]);
    }

    /** @test */
    public function next_available_achievements_can_have_no_locked_comment_achievement()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 20);

        $this->watchLesson($mehran, 25);

        $this->get(route('users.achievements.index', $mehran))
            ->assertOk()
            ->assertJson([
                'next_available_achievements' => [
                    (new FiftyLessonsWatched)->name(),
                ]
            ]);
    }

    /** @test */
    public function next_available_achievements_can_have_no_locked_lesson_achievement()
    {
        $mehran = User::factory()->create();

        $this->addComment($mehran, 10);

        $this->watchLesson($mehran, 50);

        $this->get(route('users.achievements.index', $mehran))
            ->assertOk()
            ->assertJson([
                'next_available_achievements' => [
                    (new TwentyCommentsWritten)->name(),
                ]
            ]);
    }
}
