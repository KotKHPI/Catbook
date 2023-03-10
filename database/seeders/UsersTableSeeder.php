<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = (int)$this->command->ask('How many users would you like?', 10);
        \App\Models\User::factory($userCount)->create();
    }
}
