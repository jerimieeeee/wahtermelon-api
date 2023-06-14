<?php

namespace Database\Factories\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\GenderBasedViolence\PatientGbvIntake;
use App\Models\V1\Libraries\LibGbvGeneralSurvey;
use App\Models\V1\Libraries\LibGbvInfoSource;
use App\Models\V1\Libraries\LibGbvSymptomsAnogenital;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\GenderBasedViolence\PatientGbvMedicalHistory>
 */
class PatientGbvMedicalHistoryFactory extends Factory
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
            'patient_gbv_intake_id' => fake()->randomElement(PatientGbvIntake::pluck('id')->toArray()),
            'patient_temp' => fake()->numberBetween(35, 40),
            'patient_heart_rate' => fake()->numberBetween(60, 100),
            'patient_weight' => fake()->numberBetween(40, 200),
            'patient_height' => fake()->numberBetween(100, 200),
            'taking_medication_flag' => fake()->boolean,
            'taking_medication_remarks' => fake()->sentence(),
            'general_survey_normal' => fake()->boolean,
            'general_survey_abnormal' => fake()->boolean,
            'general_survey_stunting' => fake()->boolean,
            'general_survey_wasting' => fake()->boolean,
            'general_survey_dirty_unkempt' => fake()->boolean,
            'general_survey_stuporous' => fake()->boolean,
            'general_survey_pale' => fake()->boolean,
            'general_survey_non_ambulant' => fake()->boolean,
            'general_survey_drowsy' => fake()->boolean,
            'general_survey_respiratory' => fake()->boolean,
            'general_survey_others' => fake()->boolean,
            'gbv_general_survey_remarks' => fake()->sentence(),
            'menarche_flag' => fake()->boolean,
            'menarche_remarks' => fake()->sentence(),
            'lmp_date' => fake()->dateTimeInInterval('-'.fake()->numberBetween(1, 7).' week')->format('Y-m-d'),
            'genital_discharge_uti_flag' => fake()->boolean,
            'past_hospitalizations_flag' => fake()->boolean,
            'scar_physical_abuse_flag' => fake()->boolean,
            'pertinent_med_history_flag' => fake()->boolean,
            'medical_history_remarks' => fake()->sentence(),
            'summary_non_abuse_findings' => fake()->sentence(),
        ];
    }
}
