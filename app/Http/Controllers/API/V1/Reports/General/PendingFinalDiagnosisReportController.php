<?php

namespace App\Http\Controllers\API\V1\Reports\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Reports\DailyServiceConsultationReportResource;
use App\Services\Consultation\ConsultationReportService;
use App\Services\Consultation\PendingFinalDiagnosisReportService;
use App\Services\DailyService\DailyServiceReportService;
use Illuminate\Http\Request;

class PendingFinalDiagnosisReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PendingFinalDiagnosisReportService $pendingFdx)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = $pendingFdx->get_pending_fdx();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            $keywords = explode(' ', $searchTerm);

            $query->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->where('patients.last_name', 'like', "%$keyword%")
                        ->orWhere('patients.middle_name', 'like', "%$keyword%")
                        ->orWhere('patients.first_name', 'like', "%$keyword%");
                }
            });
        }

        $data = $query->paginate($perPage);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, ConsultationReportService $consultService)
    {
        $query = $consultService->get_consultation($id);

        return DailyServiceConsultationReportResource::collection($query);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
