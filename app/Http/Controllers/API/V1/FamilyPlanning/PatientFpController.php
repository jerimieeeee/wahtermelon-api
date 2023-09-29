<?php

namespace App\Http\Controllers\API\V1\FamilyPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpRequest;
use App\Http\Resources\API\V1\FamilyPlanning\PatientFpResource;
use App\Http\Resources\API\V1\TBDots\PatientTbResource;
use App\Models\V1\FamilyPlanning\PatientFp;
use App\Models\V1\TBDots\PatientTb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientFpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientFp::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->with(['fpHistory.history', 'fpPhysicalExam.physicalExam', 'fpPelvicExam.pelvicExam', 'fpMethod.method', 'fpMethod.client', 'fpMethod.dropout', 'fpChart.source', 'fpChart.fpMethod.method', 'fpChart.fpMethod.dropout'])
            ->defaultSort('-created_at')
            ->allowedSorts('created_at');

        if ($perPage === 'all') {
            return PatientFpResource::collection($query->get());
        }

        return PatientFpResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientFpRequest $request): JsonResponse
    {
        $data = PatientFp::updateOrCreate(['patient_id' => $request->patient_id], $request->validated());

        return response()->json(['data' => new PatientFpResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientFp $patientFp): PatientFpResource
    {
        return new PatientFpResource($patientFp);
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
