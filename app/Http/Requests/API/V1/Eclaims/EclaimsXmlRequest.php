<?php

namespace App\Http\Requests\API\V1\Eclaims;

use Illuminate\Foundation\Http\FormRequest;

class EclaimsXmlRequest extends FormRequest
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
            'facility_code' => 'required|exists:facilities,code',
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
            'hci_fee' => 'required',
            'prof_fee' => 'required',
            'caserate_fee' => 'required',
            'admission_date' => 'required',
            'admission_time' => 'required',
            'discharge_date' => 'required',
            'discharge_time' => 'required',
            'attendant_accreditation_code' => 'required',
            'attendant_last_name' => 'required',
            'attendant_first_name' => 'required',
            'attendant_middle_name' => 'nullable',
            'attendant_suffix_name' => 'nullable',
            'attendant_sign_date' => 'required',
            'pICDCode' => 'nullable',
            'eclaims_caserate_list_id' => 'required',
            //TBDOTS
            'pTBType' => 'required_if:program_desc,tb',
            'pNTPCardNo' => 'required_if:program_desc,tb',
            //ANIMAL BITE
            'pDay0ARV' => 'required_if:program_desc,ab',
            'pDay3ARV' => 'required_if:program_desc,ab',
            'pDay7ARV' => 'required_if:program_desc,ab',
            'pRIG' => 'required_if:program_desc,ab',
            'pABPOthers' => 'required_if:program_desc,ab',
            'pABPSpecify' => 'nullable',
            //CHILD CARE
            'pEssentialNewbornCare' => 'required_if:program_desc,cc',
            'pNewbornHearingScreeningTest' => 'required_if:program_desc,cc',
            'pNewbornScreeningTest' => 'required_if:program_desc,cc',
            'pFilterCardNo' => 'required_if:program_desc,cc',
            //MATERNAL CARE
            'pCheckUpDate1' => 'required_if:program_desc,mc',
            'pCheckUpDate2' => 'required_if:program_desc,mc',
            'pCheckUpDate3' => 'required_if:program_desc,mc',
            'pCheckUpDate4' => 'required_if:program_desc,mc',
            'transmittalNumber' => 'nullable',
        ];
    }
}
