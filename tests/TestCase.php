<?php

namespace Tests;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param User $user
     * @param int  $times
     * @return void
     */
    protected function addComment(User $user, int $times = 1): void
    {
        do {
            $comment = Comment::factory()
                ->for($user)
                ->create();

            event(new CommentWritten($comment));

            $times--;
        } while ($times > 0);
    }

    /**
     * @param User $user
     * @param int  $times
     * @return void
     */
    protected function watchLesson(User $user, int $times = 1): void
    {
        do {
            $lesson = Lesson::factory()->create();

            $lesson->watch($user);

            event(new LessonWatched($lesson, $user));

            $times--;
        } while ($times > 0);
    }
}
