<?php

namespace App\Services\Consultation;

use App\Http\Resources\API\V1\Reports\DailyServiceConsultationReportResource;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Patient\Patient;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class ConsultationReportService
{
    public function get_consultation($request)
    {
        return Consult::with([
            'patient.householdFolder.barangay',
            'consultNotes.complaints.libComplaints',
            'vitalsLatest',
            'consultNotes.physicalExam.libPhysicalExam',
            'consultNotes.physicalExamRemarks',
            'consultNotes.initialdx.diagnosis',
            'surgicalHistory',
            'prescription',
            'prescription.konsultaMedicine',
            'prescription.medicine',
            'prescription.dosageUom',
            'prescription.doseRegimen',
            'prescription.durationFrequency',
            'prescription.medicinePurpose',
            'medicine',
            'prescription.dispensingLatest',
//            'consultpe'
        ])
        ->where('facility_code', auth()->user()->facility_code)
        ->where('id', $request->consult_id)
        ->get();
    }

    public function get_previous_consultation($request)
    {
        return Consult::with([
            'consultNotes.finaldx.libIcd10'
        ])
        ->where('facility_code', auth()->user()->facility_code)
        ->where('patient_id', $request->patient_id)
        ->get();
    }
}
