<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratoryOralGlucose>
 */
class ConsultLaboratoryOralGlucoseFactory extends Factory
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
        Patient::factory()->create();
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'OGTT']);

        return [
            'facility_code' => $consult->facility_code,
            'consult_id' => $consult->consult_id,
            'patient_id' => $consult->patient_id,
            'user_id' => $consult->user_id,
            'request_id' => $consult->id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'fasting_exam_mg' => fake()->numberBetween(1, 10),
            'fasting_exam_mmol' => fake()->numberBetween(1, 10),
            'ogtt_one_hour_mg' => fake()->numberBetween(1, 10),
            'ogtt_one_hour_mmol' => fake()->numberBetween(1, 10),
            'ogtt_two_hour_mg' => fake()->numberBetween(1, 10),
            'ogtt_two_hour_mmol' => fake()->numberBetween(1, 10),
            'remarks' => fake()->sentence(),
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
