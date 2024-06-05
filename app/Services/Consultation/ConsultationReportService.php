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
        return Patient::with([
            'consultFdx'
//            'consult.consultNotes.initialdx',
//            'consult.consultNotes'
//            'consultNotes',
//            'consult_no_fdx',
        ])
        ->when($request->filled('patient_id'), function ($q) use ($request) {
            $q->where('id', $request->patient_id);
        })
        ->when($request->filled('consult_id'), function ($q) use ($request) {
            $q->whereHas('consult', function($q) use ($request) {
                $q->where('id', $request->consult_id);
            });
        })
        ->where('facility_code', auth()->user()->facility_code)
        ->get();
    }
}
