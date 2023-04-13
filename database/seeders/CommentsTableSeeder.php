<?php

namespace Database\Seeders;

use App\Models\CatName;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = CatName::all();
        $users = User::all();

        if($cats->count() === 0) {
            $this->command->info('No cats, no comments((');
            return;
        }

        $commentCount = (int)$this->command->ask('How many comments would you like?', 50);

        \App\Models\Comment::factory($commentCount)->make()->each(function ($comment) use ($cats, $users){
            $comment->cat_name_id = $cats->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
