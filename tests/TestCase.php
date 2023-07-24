<?php

namespace Tests;

use App\Models\CatName;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user() {
        return User::factory()->create();
    }

    protected function catName() {
        return CatName::factory()->create([
            'user_id' => $this->user()->id
        ]);
    }
}
