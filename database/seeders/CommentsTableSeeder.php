<?php

namespace Database\Seeders;

use App\Models\CatName;
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
        $cats = \App\Models\CatName::all();

        if($cats->count() === 0) {
            $this->command->info('No cats, no comments((');
            return;
        }

        $commentCount = (int)$this->command->ask('How many cats would you like?', 50);

        \App\Models\Comment::factory($commentCount)->make()->each(function ($comment) use ($cats){
            $comment->cat_name_id = $cats->random()->id;
            $comment->save();
        });
    }
}
