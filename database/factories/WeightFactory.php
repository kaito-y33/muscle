<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Exercise;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weight>
 */
class WeightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'exercise_id' => function () {
                // Exerciseモデルからランダムにexercise_idを選択
                return Exercise::inRandomOrder()->value('id');
            },
            'weight' => $this->faker->randomFloat(2, 10, 100), // 1から100までのランダムな小数
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'), // 過去1年から現在までのランダムな日付
            'updated_at' => now(),
        ];
    }
}
