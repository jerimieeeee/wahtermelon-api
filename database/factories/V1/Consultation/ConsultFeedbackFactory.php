<?php

namespace Database\Factories\V1\Consultation;

use App\Models\V1\Consultation\Consult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Consultation\ConsultFeedback>
 */
class ConsultFeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'consult_id' => fake()->randomElement(Consult::pluck('id')->toArray()),
            'overall_score' => fake()->numberBetween(1, 3),
            'cleanliness_score' => fake()->numberBetween(1, 3),
            'behavior_score' => fake()->numberBetween(1, 3),
            'time_score' => fake()->numberBetween(1, 3),
            'quality_score' => fake()->numberBetween(1, 3),
            'completeness_score' => fake()->numberBetween(1, 3),
            'remarks' => fake()->sentence(),
        ];
    }
}
