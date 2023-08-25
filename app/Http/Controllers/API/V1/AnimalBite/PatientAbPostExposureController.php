<?php

namespace App\Http\Controllers\API\V1\AnimalBite;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AnimalBite\PatientAbPostExposureRequest;
use App\Http\Resources\API\V1\AnimalBite\PatientAbPostExposureResource;
use App\Http\Resources\API\V1\AnimalBite\PatientAbResource;
use App\Models\V1\AnimalBite\PatientAb;
use App\Models\V1\AnimalBite\PatientAbPostExposure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient AB
 *
 * APIs for managing AB post exposure
 *
 * @subgroup Patient AB post exposure.
 *
 * @subgroupDescription List of Patient AB post exposure.
 */
class PatientAbPostExposureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = QueryBuilder::for(PatientAbPostExposure::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->with();

        return PatientAbPostExposureResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\AnimalBite\PatientAbPostExposureResource
     *
     * @apiResourceModel App\Models\V1\AnimalBite\PatientAbPostExposure
     */
    public function store(PatientAbPostExposureRequest $request): JsonResponse
    {
        $data = PatientAbPostExposure::updateOrCreate(['patient_ab_id' => $request['patient_ab_id']], $request->validated());

        $query = QueryBuilder::for(PatientAb::class)
            ->where('id', $request->patient_ab_id)
            ->with(['abExposure', 'abPostExposure', 'treatmentOutcome'])
            ->defaultSort('-consult_date')
            ->allowedSorts('consult_date');

        return response()->json(['data' => PatientAbResource::collection($query->get()), 'status' => 'Success'], 201);
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
