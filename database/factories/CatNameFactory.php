<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CatNameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city(),
            'age' => $this->faker->numberBetween(1, 50),
            'created_at' => $this->faker->dateTimeBetween('- 3 months')
        ];
    }

//    public function states()
//    {
//        return $this->state(function (array $attributes) {
//            return [
//                'name' => 'Meoow',
//            ];
//        });
//    }
}
