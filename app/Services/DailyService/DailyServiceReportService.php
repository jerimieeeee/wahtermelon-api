<?php

namespace App\Services\DailyService;

use App\Models\V1\Consultation\Consult;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class DailyServiceReportService
{
    public function get_daily_service_consultation($request)
    {
        return Consult::with(['patient',
                            'consultNotes',
                            'patient.householdFolder',
                            'patient.householdFolder.barangay',
                            'philhealthLatest',
                            'consultNotes.complaints',
                            'consultNotes.initialdx',
                            'consultNotes.finaldx',
                            'vitalsLatest',
                            'prescription',
                            'prescription.konsultaMedicine',
                            'prescription.medicine',
                            'medicine'])
                        ->where('pt_group', 'cn')
                        ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
                        ->get();
    }

    public function get_daily_service_maternal($request)
    {
//        return Consult::with(['patient',
//            'consultNotes',
//            'patient.householdFolder',
//            'patient.householdFolder.barangay',
//            'philhealthLatest',
//            'consultNotes.complaints',
//            'consultNotes.initialdx',
//            'consultNotes.finaldx',
//            'vitalsLatest'])
//            ->where('pt_group', 'mc')
//            ->whereDate('consult_date', $request->date)
//            ->get();
    }
}
