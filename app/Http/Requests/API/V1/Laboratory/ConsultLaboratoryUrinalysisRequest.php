<?php

namespace App\Http\Requests\API\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Passport\Passport;

class ConsultLaboratoryUrinalysisRequest extends FormRequest
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
            'consult_id' => 'nullable|exists:consults,id',
            'patient_id' => 'required|exists:patients,id',
            'request_id' => 'required|exists:consult_laboratories,id',
            'laboratory_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'referral_facility' => 'nullable',
            'gravity' => 'nullable',
            'appearance' => 'nullable',
            'color' => 'nullable',
            'glucose' => 'nullable',
            'proteins' => 'nullable',
            'ketones' => 'nullable',
            'ph' => 'nullable',
            'rb_cells' => 'nullable',
            'wb_cells' => 'nullable',
            'bacteria' => 'nullable',
            'crystals' => 'nullable',
            'bladder_cells' => 'nullable',
            'squamous_cells' => 'nullable',
            'tubular_cells' => 'nullable',
            'broad_cast' => 'nullable',
            'epithelial_cast' => 'nullable',
            'granular_cast' => 'nullable',
            'hyaline_cast' => 'nullable',
            'rbc_cast' => 'nullable',
            'waxy_cast' => 'nullable',
            'wc_cast' => 'nullable',
            'albumin' => 'nullable',
            'pus_cells' => 'nullable',
            'remarks' => 'nullable',
            'lab_status_code' => 'required|exists:lib_laboratory_statuses,code',
        ];
    }

    public function bodyParameters()
    {
        Passport::actingAs(
            User::factory()->create()
        );
        $consult = ConsultLaboratory::factory()->create(['lab_code' => 'URN']);
        return [
            'facility_code' => [
                'example' => $consult->facility_code
            ],
            'consult_id' => [
                'example' => $consult->consult_id
            ],
            'patient_id' => [
                'example' => $consult->patient_id
            ],
            'user_id' => [
                'example' => $consult->user_id
            ],
            'request_id' => [
                'example' => $consult->id
            ],
            'laboratory_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d')
            ],
            'referral_facility' => [
                'example' => fake()->randomElement(Facility::pluck('code')->toArray())
            ],
            'gravity' => [
                'example' => fake()->word()
            ],
            'appearance' => [
                'example' => fake()->word()
            ],
            'color' => [
                'example' => fake()->colorName(),
            ],
            'glucose' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'proteins' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'ketones' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'ph' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'rb_cells' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'wb_cells' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'bacteria' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'crystals' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'bladder_cells' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'squamous_cells' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'tubular_cells' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'broad_cast' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'epithelial_cast' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'granular_cast' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'hyaline_cast' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'rbc_cast' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'waxy_cast' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'wc_cast' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'albumin' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'pus_cells' => [
                'example' => fake()->numberBetween(1, 10)
            ],
            'remarks' => [
                'example' => fake()->sentence()
            ],
            'lab_status_code' => [
                'example' => fake()->randomElement(LibLaboratoryStatus::pluck('code')->toArray())
            ],
        ];
    }
}
