<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Exercise;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rep>
 */
class RepFactory extends Factory
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
                // Exerciseモデルからランダムなexercise_idを選択する例
                return Exercise::inRandomOrder()->first()->id;
            },
            'rep' => $this->faker->numberBetween(6, 12), // ランダムなリパップ数
            'created_at' => $this->faker->dateTimeThisMonth,
            'updated_at' => $this->faker->dateTimeThisMonth,
        ];
    }
}
