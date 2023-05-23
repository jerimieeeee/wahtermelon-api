<?php

namespace App\Http\Requests\API\V1\GenderBasedViolence;

use Illuminate\Foundation\Http\FormRequest;

class PatientGbvLegalCaseRequest extends FormRequest
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
            'patient_gbv_intake_id' => 'required|exists:patient_gbv_intakes,id',
            'complaint_filed_flag' => 'nullable|boolean',
            'filed_by_name' => 'nullable',
            'filed_by_relation_id' => 'nullable|exists:lib_gbv_child_relations,id',
            'filed_location_id' => 'nullable|exists:lib_gbv_legal_filing_locations,id',
            'filed_location_remarks' => 'nullable',
            'case_initiated_flag' => 'nullable|boolean',
            'judge_name' => 'nullable',
            'court_name' => 'nullable',
            'fiscal_name' => 'nullable',
            'criminal_case_number' => 'nullable',
            'cpumd_testimony_date' => 'nullable|date|date_format:Y-m-d|before:tomorrow',
            'verdict_id' => 'nullable|exists:lib_gbv_outcome_verdicts,id',
        ];
    }

    /* public function bodyParameters()
    {
        return [

        ];
    } */
}
