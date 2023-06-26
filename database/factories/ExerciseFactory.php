<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Training;
use App\Models\Exercise;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $training = Training::inRandomOrder()->first();
        return [
            'user_id' => 1,
            'training_id' => $training->id,
            'date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
