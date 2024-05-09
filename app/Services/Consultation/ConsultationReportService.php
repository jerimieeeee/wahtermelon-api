<?php

namespace App\Services\Consultation;

use App\Http\Resources\API\V1\Reports\DailyServiceConsultationReportResource;
use App\Models\V1\Consultation\Consult;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class ConsultationReportService
{
    public function get_consultation($id)
    {
        return Consult::with([
            'user',
            'patient',
            'consultNotes',
            'patient.householdFolder',
//            'patient.householdFolder.municipality',
            'vitalsLatest',
            'consultNotes.complaints.libComplaints',
            'consultNotes.initialdx.diagnosis',
            'consultNotes.finaldx.libIcd10',
            'consultNotes.physicalExamRemarks',
            'prescription',
            'prescription.konsultaMedicine',
            'prescription.medicine',
            'prescription.dosageUom',
            'prescription.doseRegimen',
            'prescription.durationFrequency',
            'prescription.medicinePurpose',
            'medicine',
            'prescription.dispensingLatest',
        ])
        ->where('consults.id', $id)
        ->where('consults.facility_code', auth()->user()->facility_code)
        ->get();
    }
}
