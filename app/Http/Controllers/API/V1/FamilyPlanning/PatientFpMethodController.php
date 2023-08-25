<?php

namespace App\Http\Controllers\API\V1\FamilyPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpMethodRequest;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpMethodUpdateRequest;
use App\Http\Resources\API\V1\FamilyPlanning\PatientFpMethodResource;
use App\Http\Resources\API\V1\Patient\PatientResource;
use App\Http\Resources\API\V1\TBDots\PatientTbResource;
use App\Models\V1\FamilyPlanning\PatientFp;
use App\Models\V1\FamilyPlanning\PatientFpMethod;
use App\Models\V1\Patient\Patient;
use App\Models\V1\TBDots\PatientTb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientFpMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientFpMethod::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->where('dropout_flag', '=', 1)
            ->with('method', 'client', 'dropout', 'chart')
            ->defaultSort('enrollment_date')
            ->allowedSorts('enrollment_date', 'dropout_date');

        if ($perPage === 'all') {
            return PatientFpMethodResource::collection($query->get());
        }

        return PatientFpMethodResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientFpMethodRequest $request): JsonResponse
    {
        $data = PatientFpMethod::create($request->validated());

        return response()->json(['data' => new PatientFpMethodResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientFpMethod::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->where('dropout_flag', '=', 1)
            ->with('method', 'client', 'dropout', 'chart')
            ->defaultSort('enrollment_date')
            ->allowedSorts('enrollment_date', 'dropout_date');

        if ($perPage === 'all') {
            return PatientFpMethodResource::collection($query->get());
        }

        return PatientFpMethodResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientFpMethodUpdateRequest $request, PatientFpMethod $patientFpMethod)
    {
        $request['dropout_flag'] = 1;

        $patientFpMethod->update($request->only(['dropout_date', 'dropout_reason_code', 'dropout_remarks', 'dropout_flag']));

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientFpMethod $patientFpMethod): JsonResponse
    {
        $patientFpMethod->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
