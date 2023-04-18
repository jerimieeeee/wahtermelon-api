<?php

namespace App\Http\Requests\API\V1\TBDots;

use App\Models\V1\Libraries\LibTbPeAnswer;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientTbPeRequest extends FormRequest
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
            'patient_tb_id' => 'required|exists:patient_tbs,id',
            'abdomen' => 'required|exists:lib_tb_pe_answers,code',
            'amuscles' => 'required|exists:lib_tb_pe_answers,code',
            'bcg' => 'required|exists:lib_tb_pe_answers,code',
            'cardiovascular' => 'required|exists:lib_tb_pe_answers,code',
            'endocrine' => 'required|exists:lib_tb_pe_answers,code',
            'extremities' => 'required|exists:lib_tb_pe_answers,code',
            'ghealth' => 'required|exists:lib_tb_pe_answers,code',
            'gurinary' => 'required|exists:lib_tb_pe_answers,code',
            'lnodes' => 'required|exists:lib_tb_pe_answers,code',
            'neurological' => 'required|exists:lib_tb_pe_answers,code',
            'oropharynx' => 'required|exists:lib_tb_pe_answers,code',
            'skin' => 'required|exists:lib_tb_pe_answers,code',
            'thoraxlungs' => 'required|exists:lib_tb_pe_answers,code',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'abdomen' => [
                'description' => 'TB PE Abdomen status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'amuscles' => [
                'description' => 'TB PE Use of Accessory Muscles status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'bcg' => [
                'description' => 'TB PE BCG Scar status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'cardiovascular' => [
                'description' => 'TB PE Cardiovascular status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'endocrine' => [
                'description' => 'TB PE Endocrine status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'extremities' => [
                'description' => 'TB PE Extremities status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'ghealth' => [
                'description' => 'TB PE General Health status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'gurinary' => [
                'description' => 'TB PE Genito-urinary status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'lnodes' => [
                'description' => 'TB PE Lymph Nodes status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'neurological' => [
                'description' => 'TB PE Neurological status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'oropharynx' => [
                'description' => 'TB PE Oropharynx status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'skin' => [
                'description' => 'TB PE Skin status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
            'thoraxlungs' => [
                'description' => 'TB PE Thorax & Lungs status from library',
                'example' => fake()->randomElement(LibTbPeAnswer::pluck('code')->toArray()),
            ],
        ];
    }
}
