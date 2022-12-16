<?php

namespace App\Http\Requests\API\V1\Medicine;

use App\Models\V1\Medicine\MedicinePrescription;
use App\Models\V1\Patient\Patient;
use Illuminate\Foundation\Http\FormRequest;

class MedicineDispensingRequest extends FormRequest
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
            'dispensing_date' => 'date|date_format:Y-m-d|before:tomorrow|required',
            'prescription_id' => 'required|exists:medicine_prescriptions,id',
            'dispense_quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'remarks' => 'nullable',
        ];
    }

    public function bodyParameters()
    {
        $quantity = fake()->numberBetween(1, 50);
        $unitPrice = fake()->numberBetween(1, 500);
        $totalAmount = $quantity * $unitPrice;
        $prescription = MedicinePrescription::inRandomOrder()->limit(1)->first();
        return [
            'patient_id' => [
                'description' => 'ID of patient',
                'example' => $prescription->patient_id,
            ],
            'dispensing_date' => [
                'example' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d')
            ],
            'prescription_id' => [
                'example' => $prescription->id,
            ],
            'dispense_quantity' => [
                'example' => $quantity,
            ],
            'unit_price' => [
                'example' => $unitPrice,
            ],
            'total_amount' => [
                'example' => $totalAmount,
            ],
            'remarks' => [
                'example' => fake()->sentence(),
            ]
        ];
    }
}
