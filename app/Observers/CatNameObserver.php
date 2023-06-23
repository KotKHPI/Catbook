<?php

namespace App\Observers;

use App\Models\CatName;
use Illuminate\Support\Facades\Cache;

class CatNameObserver
{
    /**
     * Handle the CatName "created" event.
     *
     * @param  \App\Models\CatName  $catName
     * @return void
     */
    public function created(CatName $catName)
    {
        //
    }

    /**
     * Handle the CatName "updated" event.
     *
     * @param  \App\Models\CatName  $catName
     * @return void
     */
    public function updated(CatName $catName)
    {
        //
    }

    public function updating(CatName $catName)
    {
        Cache::tags(['cat-name'])->forget("cat-name-{$catName->id}");
    }

    /**
     * Handle the CatName "deleted" event.
     *
     * @param  \App\Models\CatName  $catName
     * @return void
     */
    public function deleted(CatName $catName)
    {
        //
    }

    public function deleting(CatName $catName)
    {
        $catName->comments()->delete();
        Cache::tags(['cat-name'])->forget("cat-name-{$catName->id}");
    }

    /**
     * Handle the CatName "restored" event.
     *
     * @param  \App\Models\CatName  $catName
     * @return void
     */
    public function restored(CatName $catName)
    {
        //
    }

    public function restoring(CatName $catName)
    {
        $catName->comments()->restore();
    }

    /**
     * Handle the CatName "force deleted" event.
     *
     * @param  \App\Models\CatName  $catName
     * @return void
     */
    public function forceDeleted(CatName $catName)
    {
        //
    }
}
