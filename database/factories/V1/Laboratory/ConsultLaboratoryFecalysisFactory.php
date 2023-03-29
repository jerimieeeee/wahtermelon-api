<?php

namespace Database\Factories\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryBloodInStool;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Libraries\LibLaboratoryStoolColor;
use App\Models\V1\Libraries\LibLaboratoryStoolConsistency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Passport\Passport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Laboratory\ConsultLaboratoryFecalysis>
 */
class ConsultLaboratoryFecalysisFactory extends Factory
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
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'FCAL']);

        return [
            'facility_code' => $consult->facility_code,
            'consult_id' => $consult->consult_id,
            'patient_id' => $consult->patient_id,
            'user_id' => $consult->user_id,
            'request_id' => $consult->id,
            'laboratory_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'color_code' => fake()->randomElement(LibLaboratoryStoolColor::pluck('code')->toArray()),
            'consistency_code' => fake()->randomElement(LibLaboratoryStoolConsistency::pluck('code')->toArray()),
            'rbc' => fake()->numberBetween(1, 10),
            'wbc' => fake()->numberBetween(1, 10),
            'ova' => fake()->numberBetween(1, 10),
            'parasite' => fake()->numberBetween(1, 10),
            'blood_code' => fake()->randomElement(LibLaboratoryBloodInStool::pluck('code')->toArray()),
            'pus_cells' => fake()->numberBetween(1, 10),
            'remarks' => fake()->sentence(),
            'lab_status_code' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray()),
        ];
    }
}
