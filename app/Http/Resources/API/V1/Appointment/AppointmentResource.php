<?php

namespace App\Http\Resources\API\V1\Appointment;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? $this->id,
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'appointment_code' => $this->when(! $this->relationLoaded('appointment'), $this->appointment_code),
            'appointment' => $this->whenLoaded('appointment'),
            'appointment_date' => Carbon::parse($this->appointment_date)->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];

//        $appointments = [];
//
//        foreach ($this->collection as $appointment) {
//            $appointments[] = [
//                'id' => $appointment->id,
//                'patient_id' => $appointment->patient_id,
//                'appointment_code' => $appointment->appointment_code,
//                'appointment_date' => $appointment->appointment_date,
//                'created_at' => $appointment->created_at,
//                'updated_at' => $appointment->updated_at,
//            ];
//        }
//
//        return [
//            'data' => $appointments,
//            'links' => [
//                'self' => $this->url($request->input('page', 1)),
//            ],
//            'meta' => [
//                'total' => $this->total(),
//                'per_page' => $this->perPage(),
//                'current_page' => $this->currentPage(),
//                'last_page' => $this->lastPage(),
//                'path' => $this->path(),
//            ],
//        ];
    }
}
