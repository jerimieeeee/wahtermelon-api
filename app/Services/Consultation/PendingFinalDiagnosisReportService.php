<?php

namespace App\Services\Consultation;

use App\Models\V1\Consultation\Consult;
use Illuminate\Support\Facades\DB;

class PendingFinalDiagnosisReportService
{
    public function get_pending_fdx($request)
    {
        return Consult::with(['consultNotes', 'physician', 'user'])
            ->whereYear('consult_date', '>=', '2023')
            ->when($request->filled('physician_id'), function ($q) use ($request) {
                $q->where('physician_id', $request->physician_id);
            })
            ->when($request->filled('is_konsulta'), function ($q) use ($request) {
                $q->where('is_konsulta', $request->is_konsulta);
            })
            ->where('consult_done', 1)
            ->where(function ($query) {
                $query->whereNotNull('physician_id')
                    ->whereDoesntHave('finalDiagnosis');
        });
    }
}
