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

        if($cats->count() === 0 || $users->count() === 0) {
            $this->command->info('No cats or no users? So no comments((');
            return;
        }

        $commentCount = (int)$this->command->ask('How many comments would you like?', 50);

        \App\Models\Comment::factory($commentCount)->make()->each(function ($comment) use ($cats, $users){
            $comment->commentable_id = $cats->random()->id;
            $comment->commentable_type = 'App\Models\CatName';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        \App\Models\Comment::factory($commentCount)->make()->each(function ($comment) use ($users){
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = 'App\Models\User';
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}
