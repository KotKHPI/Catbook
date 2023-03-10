<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CatNamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();

        if($users->count() === 0) {
            $this->command->info('No users, no cats((');
        }

        $catCount = (int)$this->command->ask('How many cats would you like?', 25);

        \App\Models\CatName::factory( $catCount)->make()->each(function ($cat) use ($users) {
            $cat->user_id = $users->random()->id;
            $cat->save();
        });
    }
}
