<?php

namespace App\Http\Requests\API\V1\Medicine;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibKonsultaMedicine;
use App\Models\V1\Libraries\LibMedicineDoseRegimen;
use App\Models\V1\Libraries\LibMedicineDurationFrequency;
use App\Models\V1\Libraries\LibMedicinePreparation;
use App\Models\V1\Libraries\LibMedicinePurpose;
use App\Models\V1\Libraries\LibMedicineRoute;
use App\Models\V1\Libraries\LibMedicineUnitOfMeasurement;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class MedicinePrescriptionRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'prescribed_by' => 'required|exists:users,id',
            'consult_id' => 'nullable|exists:consults,id',
            'prescription_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'konsulta_medicine_code' => 'required_without:added_medicine|exists:lib_konsulta_medicines,code',
            'added_medicine' => 'required_without:konsulta_medicine_code',
            'instruction_quantity' => 'required:numeric',
            'dosage_quantity' => 'required:numeric',
            'dosage_uom' => 'required:exists:lib_medicine_unit_of_measurements,code',
            'dose_regimen' => 'required:exists:lib_medicine_dose_regimens,code',
            'medicine_purpose' => 'required:exists:lib_medicine_purposes,code',
            'purpose_other' => 'nullable',
            'duration_intake' => 'required:numeric',
            'duration_frequency' => 'required:exists:lib_medicine_duration_frequencies,code',
            'quantity' => 'required:numeric',
            'quantity_preparation' => 'required:exists:lib_medicine_preparations,code',
            'medicine_route_code' => 'required:exists:lib_medicine_routes,code',
        ];
    }

    public function bodyParameters()
    {
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => fake()->randomElement(Patient::pluck('id')->toArray()),
            ],
            'prescription_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            ],
            'prescribed_by' => [
                'example' => fake()->randomElement(User::pluck('id')->toArray()),
            ],
            'consult_id' => [
                'example' => fake()->randomElement(Consult::pluck('id')->toArray()),
            ],
            'konsulta_medicine_code' => [
                'example' => fake()->randomElement(LibKonsultaMedicine::pluck('code')->toArray()),
            ],
            'instruction_quantity' => [
                'example' => fake()->numberBetween(1, 500),
            ],
            'dosage_quantity' => [
                'example' => fake()->numberBetween(1, 500),
            ],
            'dosage_uom' => [
                'example' => fake()->randomElement(LibMedicineUnitOfMeasurement::pluck('code')->toArray()),
            ],
            'dose_regimen' => [
                'example' => fake()->randomElement(LibMedicineDoseRegimen::pluck('code')->toArray()),
            ],
            'medicine_purpose' => [
                'example' => fake()->randomElement(LibMedicinePurpose::pluck('code')->toArray()),
            ],
            'duration_intake' => [
                'example' => fake()->numberBetween(1, 50),
            ],
            'duration_frequency' => [
                'example' => fake()->randomElement(LibMedicineDurationFrequency::pluck('code')->toArray()),
            ],
            'quantity' => [
                'example' => fake()->numberBetween(1, 50),
            ],
            'quantity_preparation' => [
                'example' => fake()->randomElement(LibMedicinePreparation::pluck('code')->toArray()),
            ],
            'medicine_route_code' => [
                'example' => fake()->randomElement(LibMedicineRoute::pluck('code')->toArray()),
            ],
        ];
    }
}
