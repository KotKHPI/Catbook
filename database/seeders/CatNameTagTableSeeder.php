<?php

namespace Database\Seeders;

use App\Models\CatName;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class CatNameTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount = Tag::all()->count();

        if(0 === $tagCount) {
            $this->command->info('No tags found, skipping');
            return;
        }

        $howManyMin = (int)$this->command->ask('How many minimum tags on cat?', 0);
        $howManyMax = min((int)$this->command->ask('How many maximum tags on cat?', $tagCount), $tagCount);

        CatName::all()->each(function (CatName $cat) use ($howManyMin, $howManyMax) {
            $take = random_int($howManyMin, $howManyMax);
            $tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');
            $cat->tags()->sync($tags);
        });
    }
}
