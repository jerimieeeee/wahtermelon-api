<?php

namespace Database\Factories\V1\TBDots;

use App\Models\User;
use App\Models\V1\Libraries\LibTbPe;
use App\Models\V1\Libraries\LibTbPeAnswer;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\TBDots\PatientTbPe>
 */
class PatientTbPeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'abdomen' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'amuscles' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'bcg' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'cardiovascular' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'endocrine' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'extremities' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'ghealth' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'gurinary' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'lnodes' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'neurological' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'oropharynx' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'skin' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            'thoraxlungs' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
        ];
    }
}
