<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use App\Models\V1\Libraries\LibGbvOutcomeReason;
use App\Models\V1\Libraries\LibGbvOutcomeResult;
use App\Models\V1\Libraries\LibGbvOutcomeVerdict;
use App\Models\V1\Libraries\LibGbvPrimaryComplaints;
use App\Models\V1\Libraries\LibGbvService;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientGbvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'case_number' => 'nullable|alpha_num',
            'case_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'outcome_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'outcome_reason_id' => 'nullable|exists:lib_gbv_outcome_reasons,id',
            'outcome_result_id' => 'nullable|exists:lib_gbv_outcome_results,id',
            'outcome_verdict_id' => 'nullable|exists:lib_gbv_outcome_verdicts,id',
            'primary_complaint_id' => 'nullable|exists:lib_gbv_primary_complaints,id',
            'service_id' => 'nullable|exists:lib_gbv_services,id',
            'primary_complaint_remarks' => 'nullable',
            'physical_abuse_flag' => 'nullable|boolean',
            'sexual_abuse_flag' => 'nullable|boolean',
            'neglect_abuse_flag' => 'nullable|boolean',
            'emotional_abuse_flag' => 'nullable|boolean',
            'economic_abuse_flag' => 'nullable|boolean',
            'utv_abuse_flag' => 'nullable|boolean',
            'others_abuse_flag' => 'nullable|boolean',
            'others_abuse_remarks' => 'nullable',
            'service_remarks' => 'nullable',
            'neglect_remarks' => 'nullable',
            'behavioral_remarks' => 'nullable',
            'economic_status_id' => 'nullable|exists:lib_gbv_economic_statuses,id',
            'number_of_children' => 'nullable',
            'number_of_individual_members' => 'nullable',
            'number_of_family' => 'nullable',
            'barangay_code' => 'nullable|exists:barangays,code',
            'address' => 'nullable',
            'direction_to_address' => 'nullable',
            'guardian_name' => 'nullable',
            'guardian_address' => 'nullable',
            'relation_to_child_id' => 'nullable|exists:lib_gbv_child_relations,id',
            'guardian_contact_info' => 'nullable',
            'incest_case_flag' => 'nullable|boolean',
            'same_bed_adult_male_flag' => 'nullable|boolean',
            'same_bed_adult_female_flag' => 'nullable|boolean',
            'same_bed_child_male_flag' => 'nullable|boolean',
            'same_bed_child_female_flag' => 'nullable|boolean',
            'same_room_adult_male_flag' => 'nullable|boolean',
            'same_room_adult_female_flag' => 'nullable|boolean',
            'same_room_child_male_flag' => 'nullable|boolean',
            'sleeping_arrangement_id' => 'nullable|exists:lib_gbv_sleeping_arrangements,id',
            'abuse_living_arrangement_id' => 'nullable|exists:lib_gbv_living_arrangements,id',
            'abuse_living_arrangement_remarks' => 'nullable',
            'present_living_arrangement_id' => 'nullable|exists:lib_gbv_living_arrangements,id',
            'present_living_arrangement_remarks' => 'nullable',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'case_date' => [
                'description' => 'Case date of Patient GBV',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'outcome_date' => [
                'description' => 'Outcome date of Patient GBV',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
            'outcome_reason_id' => [
                'description' => 'Treatment outcome of patient from library',
                'example' => fake()->randomElement(LibGbvOutcomeReason::pluck('id')->toArray()),
            ],
            'outcome_result_id' => [
                'description' => 'Outcome reason for died and stop tb treatent from library',
                'example' => fake()->randomElement(LibGbvOutcomeResult::pluck('id')->toArray()),
            ],
            'outcome_verdict_id' => [
                'description' => 'Outcome reason for died and stop tb treatent from library',
                'example' => fake()->randomElement(LibGbvOutcomeVerdict::pluck('id')->toArray()),
            ],
            'primary_complaint_id' => [
                'description' => 'Outcome reason for died and stop tb treatent from library',
                'example' => fake()->randomElement(LibGbvPrimaryComplaints::pluck('id')->toArray()),
            ],
            'service_id' => [
                'description' => 'Outcome reason for died and stop tb treatent from library',
                'example' => fake()->randomElement(LibGbvService::pluck('id')->toArray()),
            ],
            'primary_complaint_remarks' => [
                'description' => 'Primary complaint remarks of Patient GBV',
                'example' => fake()->sentence(),
            ],
            'service_remarks' => [
                'description' => 'service remarks of Patient GBV',
                'example' => fake()->sentence(),
            ],
            'neglect_remarks' => [
                'description' => 'Neglect remarks of Patient GBV',
                'example' => fake()->sentence(),
            ],
            'behavioral_remarks' => [
                'description' => 'Behavioral remarks of Patient GBV',
                'example' => fake()->sentence(),
            ],
        ];
    }
}
