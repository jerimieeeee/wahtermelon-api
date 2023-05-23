<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use App\Models\V1\Libraries\LibGbvPrimaryComplaints;
use App\Models\V1\Libraries\LibGbvService;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientGbvIntakeRequest extends FormRequest
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
            'patient_gbv_id' => 'required|exists:patient_gbvs,id',
            'case_number' => 'nullable|alpha_num',
            'case_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
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
            'same_address_flag' => 'nullable|boolean',
            'barangay_code' => 'nullable|exists:barangays,code',
            'address' => 'nullable',
            'direction_to_address' => 'nullable',
            'guardian_name' => 'nullable',
            'guardian_address' => 'nullable',
            'relation_to_child_id' => 'nullable|exists:lib_gbv_child_relations,id',
            'guardian_contact_info' => 'nullable|min:11|max:13',
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

            'vaw_physical_flag' => 'nullable|boolean',
            'vaw_sexual_flag' => 'nullable|boolean',
            'vaw_psychological_flag' => 'nullable|boolean',
            'vaw_economic_flag' => 'nullable|boolean',
            'rape_sex_intercourse_flag' => 'nullable|boolean',
            'rape_sex_assault_flag' => 'nullable|boolean',
            'rape_incest_flag' => 'nullable|boolean',
            'rape_statutory_flag' => 'nullable|boolean',
            'rape_marital_flag' => 'nullable|boolean',
            'harassment_verbal_flag' => 'nullable|boolean',
            'harassment_physical_flag' => 'nullable|boolean',
            'harassment_object_flag' => 'nullable|boolean',
            'child_abuse_engaged_flag' => 'nullable|boolean',
            'child_abuse_sexual_flag' => 'nullable|boolean',
            'wcpd_others' => 'nullable',
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
