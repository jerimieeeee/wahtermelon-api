<?php

namespace App\Http\Controllers\API\V1\FamilyPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpChartRequest;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpChartUpdateRequest;
use App\Http\Resources\API\V1\FamilyPlanning\PatientFpChartResource;
use App\Models\V1\FamilyPlanning\PatientFpChart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientFpChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientFpChart::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->with(['fpMethod', 'fpMethod.dropout', 'fpMethod.method', 'source'])
            ->defaultSort('service_date')
            ->allowedSorts('enrollment_date', 'next_service_date')
            ->orderBy('service_date', 'DESC');

        if ($perPage === 'all') {
            return PatientFpChartResource::collection($query->get());
        }

        return PatientFpChartResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientFpChartRequest $request): JsonResponse
    {
        $data = PatientFpChart::create($request->validated());

        return response()->json(['data' => new PatientFpChartResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientFpChartUpdateRequest $request, PatientFpChart $patientFpChart)
    {
        $patientFpChart->update($request->only(['service_date', 'source_supply_code', 'quantity', 'remarks']));

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientFpChart $patientFpChart)
    {
        $patientFpChart->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
