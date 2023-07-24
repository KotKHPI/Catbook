<?php

namespace App\Listeners;

use App\Events\CatPosted;
use App\Jobs\ThrottledMail;
use App\Mail\CatAdded;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminWhenCatCreated
{
    public function handle(CatPosted $event)
    {
        User::thatIsAnAdmin()->get()
            ->map(function (User $user){
                ThrottledMail::dispatch(
                    new CatAdded(),
                    $user
                );
            });
    }
}
