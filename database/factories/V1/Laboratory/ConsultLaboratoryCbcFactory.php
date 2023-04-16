<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratoryCbc>
 */
class ConsultLaboratoryCbcFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        //$consult = ConsultLaboratory::whereLabCode('CBC')->inRandomOrder()->limit(1)->first();
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'CBC']);

        return [
            'facility_code' => $consult->facility_code,
            'user_id' => $consult->user_id,
            'patient_id' => $consult->patient_id,
            'consult_id' => $consult->consult_id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'request_id' => $consult->id,
            'hemoglobin' => fake()->numberBetween(1, 10),
            'hematocrit' => fake()->numberBetween(1, 10),
            'rbc' => fake()->numberBetween(1, 10),
            'mcv' => fake()->numberBetween(1, 10),
            'mch' => fake()->numberBetween(1, 10),
            'mchc' => fake()->numberBetween(1, 10),
            'wbc' => fake()->numberBetween(1, 10),
            'neutrophils' => fake()->numberBetween(1, 10),
            'lymphocytes' => fake()->numberBetween(1, 10),
            'basophils' => fake()->numberBetween(1, 10),
            'monocytes' => fake()->numberBetween(1, 10),
            'eosinophils' => fake()->numberBetween(1, 10),
            'stab' => fake()->numberBetween(1, 10),
            'juvenile' => fake()->numberBetween(1, 10),
            'platelets' => fake()->numberBetween(1, 10),
            'reticulocytes' => fake()->numberBetween(1, 10),
            'bleeding_time' => fake()->numberBetween(1, 10),
            'clothing_time' => fake()->numberBetween(1, 10),
            'esr' => fake()->numberBetween(1, 10),
            'remarks' => fake()->sentence(),
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
