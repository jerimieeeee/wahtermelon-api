<?php

namespace Database\Factories\V1\Patient;

use App\Models\User;
use App\Models\V1\Libraries\LibMedicalHistory;
use App\Models\V1\Libraries\LibMedicalHistoryCategory;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Patient\PatientHistory>
 */
class PatientHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => fake()->randomElement(Patient::pluck('id')->toArray()),
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'facility_code' => fake()->randomElement(Facility::pluck('code')->toArray()),
            'medical_history_id' => fake()->randomElement(LibMedicalHistory::pluck('id')->toArray()),
            'category' => fake()->randomElement(LibMedicalHistoryCategory::pluck('id')->toArray()),
            'remarks' => fake()->sentence,
        ];
    }
}
