<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratoryBloodChemistry>
 */
class ConsultLaboratoryBloodChemistryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Passport::actingAs(
            User::factory()->create()
        );
        Patient::factory()->create();
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'BCHM']);

        return [
            'facility_code' => $consult->facility_code,
            'user_id' => $consult->user_id,
            'patient_id' => $consult->patient_id,
            'consult_id' => $consult->consult_id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'referral_facility' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'request_id' => $consult->id,

            //Electrolytes
            'bicarbonate' => fake()->numberBetween(1, 20),
            'calcium' => fake()->numberBetween(1, 20),
            'chloride' => fake()->numberBetween(1, 20),
            'magnesium' => fake()->numberBetween(1, 20),
            'phosphorus' => fake()->numberBetween(1, 20),
            'potassium' => fake()->numberBetween(1, 20),
            'sodium' => fake()->numberBetween(1, 20),

            //Enzymes
            'alkaline_phosphatase' => fake()->numberBetween(1, 20),
            'amylase' => fake()->numberBetween(1, 20),
            'creatine_kinase' => fake()->numberBetween(1, 20),
            'lipase' => fake()->numberBetween(1, 20),
            'alt' => fake()->numberBetween(1, 20),
            'ast' => fake()->numberBetween(1, 20),

            //Others
            'albumin' => fake()->numberBetween(1, 20),
            'total_bilirubin' => fake()->numberBetween(1, 20),
            'direct_bilirubin' => fake()->numberBetween(1, 20),
            'cholesterol' => fake()->numberBetween(1, 20),
            'creatinine' => fake()->numberBetween(1, 20),
            'globulin' => fake()->numberBetween(1, 20),
            'glucose' => fake()->numberBetween(1, 20),
            'protein' => fake()->numberBetween(1, 20),
            'triglycerides' => fake()->numberBetween(1, 20),
            'urea' => fake()->numberBetween(1, 20),
            'uric_acid' => fake()->numberBetween(1, 20),
            'fbs' => fake()->numberBetween(1, 20),
            'rbs' => fake()->numberBetween(1, 20),

            'remarks' => fake()->numberBetween(1, 20),
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
