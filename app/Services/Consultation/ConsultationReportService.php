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
            'initialdx',
            'patient_vitals',
            'finaldx',
            'consultpe'
        ])
        ->when($request->filled('consult_id'), function ($q) use ($request) {
            $q->whereHas('finaldx', function($q) use ($request) {
                $q->where('consult_id', $request->consult_id);
                });
            })
        ->where('facility_code', auth()->user()->facility_code)
        ->get();
    }
}
