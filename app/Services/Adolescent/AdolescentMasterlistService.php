<?php

namespace App\Services\Adolescent;

use App\Http\Resources\API\V1\Reports\DailyServiceConsultationReportResource;
use App\Models\V1\Adolescent\ConsultAsrhRapid;
use App\Models\V1\Consultation\Consult;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use App\Services\ReportFilter\CategoryFilterService;

class   AdolescentMasterlistService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_adolescent_masterlist($request)
    {
        return ConsultAsrhRapid::with([
            'patient.genderIdentity',
            'patient.menstrualHistory',
            'patient.vitals',
//            'vitalsAsrh',
            'livingArrangementType',
            'consult',
            'consult.consultNotes',
            'consult.consultNotes.complaints.libComplaints',
            'consult.consultNotes.physicalExam.libPhysicalExam',
            'consult.consultNotes.finaldx.libIcd10',
            'patient.householdFolder.barangay',
            'patient.education',
            'patient.socialHistory',
            'patient.pregnancyHistory',
            'clientTypes',
            'comprehensive',
            'answersQuestion3'
        ])
        ->tap(function ($query) use ($request) {
            $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_asrh_rapids.facility_code', 'consult_asrh_rapids.patient_id');
        })
        ->whereBetween(DB::raw('DATE(assessment_date)'), [$request->start_date, $request->end_date])
//        ->orderBy('consult_date')
        ->get();
    }
}
