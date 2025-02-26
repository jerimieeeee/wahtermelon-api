<?php

namespace App\Http\Controllers\API\V1\Reports\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Consultation\GetPendingFinalDxResource;
use App\Http\Resources\API\V1\Consultation\PreviousFinalDxResource;
use App\Services\Consultation\ConsultationReportService;
use App\Services\Consultation\PendingFinalDiagnosisReportService;
use Illuminate\Http\Request;

class PendingFinalDiagnosisReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PendingFinalDiagnosisReportService $pendingFdx)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        // Start the query
        $query = $pendingFdx->get_pending_fdx($request)->orderBy('consult_date', 'DESC');

        // Apply search conditions
        $columns = ['last_name', 'first_name', 'middle_name'];

        $query->withWhereHas('patient', function ($query) use ($columns, $request) {
            $query->when(isset($request->search), function ($q) use ($request, $columns) {
                $q->orSearch($columns, 'LIKE', $request->search);
            });
        });

//        return $query->get();

        if ($perPage === 'all') {
            return GetPendingFinalDxResource::collection($query->get());
        }

        return GetPendingFinalDxResource::collection($query->paginate($perPage)->withQueryString());
    }

    public function index2(Request $request, ConsultationReportService $consultService)
    {
        $query = $consultService->get_consultation($request);

        $query2 = $consultService->get_previous_consultation($request);

//        return $query2;

//        $query2 = PreviousFinalDxResource::collection($query2);

//        $data = $query->paginate($perPage);

        return [
            'data' => $query,
            'previous_diagnosis' => $query2
        ];

//        return PendingFinalDxResource::collection($data);

//        return response()->json([
//            'data' => PendingFinalDxResource::collection($data),
//            'additional_info' => $additionalData,
//        ]);
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
    public function show(string $id)
    {
//        $query = $consultService->get_consultation($id);
//
//        return DailyServiceConsultationReportResource::collection($query);
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
