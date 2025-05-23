<?php

namespace App\Services\DailyService;

use App\Http\Resources\API\V1\Reports\DailyServiceConsultationReportResource;
use App\Models\V1\Consultation\Consult;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use App\Services\ReportFilter\CategoryFilterService;

class DailyServiceReportService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_all_brgy_municipalities_patient()
    {
        return DB::table('municipalities')
            ->selectRaw('
                        patient_id,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.psgc_10_digit_code AS barangay_code
                    ')
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.psgc_10_digit_code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id');
    }

    public function get_catchment_barangays()
    {
        $result = DB::table('settings_catchment_barangays')
            ->selectRaw('
                        facility_code,
                        barangay_code
                    ')
            ->whereFacilityCode(auth()->user()->facility_code);

        return $result->pluck('barangay_code');
    }

    public function get_daily_service_consultation($request)
    {
        return Consult::with([
            'user.designation',
            'patient',
            'consultNotes',
            'patient.householdFolder',
            'patient.householdFolder.barangay',
            'philhealthLatest',
            'vitalsLatest',
            'consultNotes.complaints.libComplaints',
            'consultNotes.initialdx.diagnosis',
            'consultNotes.finaldx.libIcd10',
            'consultNotes.finaldx.user.designation',
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
        ->tap(function ($query) use ($request) {
            $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
        })
        ->where('pt_group', 'cn')
        ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
        ->orderBy('consult_date')
        ->get();
    }
}
