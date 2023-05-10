<?php

namespace App\Jobs;

use App\Mail\CommentPostedOnCatWatched;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUsersCatWasCommented implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::thatHasCommentedOnCat($this->comment->commentable)
        ->get()
        ->filter(function (User $user) {
            return $user->id !== $this->comment->user->id;
        })->map(function (User $user) {
            Mail::to($user)->send(
                new CommentPostedOnCatWatched($this->comment, $user)
            );
            });
    }
}
