<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'consult_id' => fake()->randomElement(Consult::pluck('id')->toArray()),
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'request_id' => fake()->randomElement(ConsultLaboratory::pluck('id')->toArray()),
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
