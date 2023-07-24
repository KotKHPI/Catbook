<?php

namespace App\Http\ViewComposers;

use App\Models\CatName;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer {
    public function compose(View $view)
    {
        $mostCommented = Cache::tags(['cat-name'])->remember('mostCommented', 60, function() {
            return CatName::mostCommented()->take(5)->get();
        });

        $mostActive = Cache::tags(['cat-name'])->remember('mostActive', 60, function() {
            return User::withMostCatNames()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::tags(['cat-name'])->remember('mostActiveLastMonth', 60, function() {
            return User::withMostCatNamesLastMonth()->take(5)->get();
        });

        $view->with('mostCommented', $mostCommented);
        $view->with('mostActive', $mostActive);
        $view->with('mostActiveLastMonth', $mostActiveLastMonth);

    }
}
