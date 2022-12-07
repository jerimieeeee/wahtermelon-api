<?php

namespace App\Http\Requests\API\V1\Childcare;

use App\Models\User;
use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;

class ConsultCcdevBreastfedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'patient_ccdev_id' => 'required|exists:patient_ccdevs,id',
            'patient_id' => 'required|exists:patients,id',
            // 'user_id' => 'required|exists:users,id',
            // 'facility_code' => 'nullable|exists:facilities,code',
            'bfed_month1' => 'boolean|nullable',
            'bfed_month2' => 'boolean|nullable',
            'bfed_month3' => 'boolean|nullable',
            'bfed_month4' => 'boolean|nullable',
            'bfed_month5' => 'boolean|nullable',
            'bfed_month6' => 'boolean|nullable',
            'reason' => 'nullable|exists:lib_ebf_reasons,reason_id',
            'ebf_date' => 'date|date_format:Y-m-d|nullable',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_ccdev_id' => [
                'description' => 'ID of ccdev.',
                'example' => fake()->randomElement(PatientCcdev::pluck('id')->toArray()),
            ],
            // 'patient_id' => [
            //     'description' => 'ID of patient',
            //     'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            // ],
            // 'user_id' => [
            //     'description' => 'ID of user.',
            //     'example' => fake()->randomElement(User::pluck('id')->toArray()),
            // ],
            'facility_code' => [
                'description' => 'code of facility.',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'bfed_month1' => [
                'description' => 'Breastfed Month 1.',
                'example' => fake()->boolean(),
            ],
            'bfed_month2' => [
                'description' => 'Breastfed Month 2',
                'example' => fake()->boolean(),
            ],
            'bfed_month3' => [
                'description' => 'Breastfed Month 3',
                'example' => fake()->boolean(),
            ],
            'bfed_month4' => [
                'description' => 'Breastfed Month 4',
                'example' => fake()->boolean(),
            ],
            'bfed_month5' => [
                'description' => 'Breastfed Month 5',
                'example' => fake()->boolean(),
            ],
            'bfed_month6' => [
                'description' => 'Breastfed Month 6',
                'example' => fake()->boolean(),
            ],
            'ebf_date' => [
                'description' => 'Date of ebf.',
                'example' => fake()->date($format = 'Y-m-d', $max = 'now'),
            ],
        ];

    }

}
