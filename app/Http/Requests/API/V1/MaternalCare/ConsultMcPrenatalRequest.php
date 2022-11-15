<?php

namespace App\Http\Requests\API\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Libraries\LibMcLocation;
use App\Models\V1\Libraries\LibMcPresentation;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use Illuminate\Foundation\Http\FormRequest;

class ConsultMcPrenatalRequest extends FormRequest
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
    public function validatedWithCasts(): array
    {
        $mc = PatientMcPreRegistration::select('id', 'lmp_date', 'trimester1_date', 'trimester2_date')->where('patient_mc_id', request()->patient_mc_id)->first();

        list($weeks,$remainingDays) = get_aog($mc->lmp_date, request()->prenatal_date);
        $trimester = get_trimester(request()->prenatal_date, $mc->trimester1_date, $mc->trimester2_date);

        return array_merge($this->validated(), [
            'aog_weeks' => $weeks,
            'aog_days' => $remainingDays,
            'trimester' => $trimester,
            'visit_sequence' => 0,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'patient_mc_id' => 'required|exists:patient_mc,id',
            'facility_code' => 'exists:facilities,code',
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'prenatal_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'patient_height' => 'required|numeric',
            'patient_weight' => 'required|numeric',
            'bp_systolic' => 'required|numeric',
            'bp_diastolic' => 'required|numeric',
            'fundic_height' => 'numeric',
            'presentation_code' => 'required|exists:lib_mc_presentations,code',
            'fhr' => 'numeric',
            'location_code' => 'required|exists:lib_mc_locations,code',
            'private' => 'boolean'
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_mc_id' => [
                'description' => 'ID of maternal care record',
                'example' => fake()->randomElement(PatientMc::pluck('id')->toArray()),
            ],
            'facility_code' => [
                'description' => 'ID of facility library',
                'example' => fake()->randomElement(Facility::pluck('code')->toArray()),
            ],
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'user_id' => [
                'description' => 'ID of user',
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
            'presentation_code' => [
                'description' => 'Code of presentation library',
                'example' => fake()->randomElement(LibMcPresentation::pluck('code')->toArray()),
            ],
            'location_code' => [
                'description' => 'Code of location library',
                'example' => fake()->randomElement(LibMcLocation::pluck('code')->toArray()),
            ],
            'patient_height' => [
                'description'  => 'Height of the patient',
                'example' => fake()->numberBetween(100, 200)
            ],
            'patient_weight' => [
                'description'  => 'Weight of the patient',
                'example' => fake()->numberBetween(40, 200)
            ],
            'bp_systolic' => [
                'description'  => 'Blood pressure systolic',
                'example' => fake()->numberBetween(100, 200)
            ],
            'bp_diastolic' => [
                'description'  => 'Blood pressure diastolic',
                'example' => fake()->numberBetween(70, 100)
            ],
            'fundic_height' => [
                'example' => fake()->numberBetween(0, 50)
            ],
            'fhr' => [
                'example' => fake()->numberBetween(0, 50)
            ],
            'private' => [
                'example' => fake()->boolean()
            ],
        ];
    }
}
