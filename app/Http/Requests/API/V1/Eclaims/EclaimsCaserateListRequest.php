<?php

namespace App\Http\Requests\API\V1\Eclaims;

use Illuminate\Foundation\Http\FormRequest;

class EclaimsCaserateListRequest extends FormRequest
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
            'id' => 'nullable',
            'patient_id' => 'required|exists:patients,id',
            'program_desc' => 'required',
            'program_id' => 'required',
            'admit_dx' => 'required',
            'caserate_date' => 'required',
            'caserate_code' => 'required',
            'code' => 'required',
            'description' => 'required',
            'discharge_dx' => 'required',
            'icd10_code' => 'required|exists:lib_icd10s,icd10_code',
            'hci_fee' => 'required|numeric',
            'prof_fee' => 'required|numeric',
            'caserate_fee' => 'required|numeric',
            'caserate_attendant' => 'required',
            'enough_benefit_flag' => 'nullable|boolean',
            'hci_pTotalActualCharges' => 'nullable|numeric',
            'hci_pDiscount' => 'nullable|numeric',
            'hci_pPhilhealthBenefit' => 'nullable|numeric',
            'hci_pTotalAmount' => 'nullable|numeric',
            'prof_pTotalActualCharges' => 'nullable|numeric',
            'prof_pDiscount' => 'nullable|numeric',
            'prof_pPhilhealthBenefit' => 'nullable|numeric',
            'prof_pTotalAmount' => 'nullable|numeric',
            'meds_flag' => 'nullable|boolean',
            'meds_pDMSTotalAmount' => 'nullable|numeric',
            'meds_pExaminations_flag' => 'nullable|boolean',
            'meds_pExamTotalAmount' => 'nullable|numeric',
            'hmo_flag' => 'nullable|boolean',
            'others_flag' => 'nullable|boolean'
        ];
    }
}
