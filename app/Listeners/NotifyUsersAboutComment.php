<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUsersCatWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUsersAboutComment
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        dd($event);
        ThrottledMail::dispatch(new CommentPostedMarkdown($event->comment), $event->comment->commentable->user)
            ->onQueue('low');;
        NotifyUsersCatWasCommented::dispatch($event->comment)
            ->onQueue('high');
    }
}
