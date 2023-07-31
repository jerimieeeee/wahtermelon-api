<?php

namespace Database\Factories\V1\FamilyPlanning;

use App\Models\User;
use App\Models\V1\FamilyPlanning\PatientFp;
use App\Models\V1\Libraries\LibFpHistory;
use App\Models\V1\Libraries\LibFpPelvicExam;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\FamilyPlanning\PatientFpPelvicExam>
 */
class PatientFpPelvicExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_fp_id' => fake()->randomElement(PatientFp::pluck('id')->toArray()),
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'pelvic_exam_code' => fake()->randomElement(LibFpPelvicExam::pluck('code')->toArray()),
        ];
    }
}
