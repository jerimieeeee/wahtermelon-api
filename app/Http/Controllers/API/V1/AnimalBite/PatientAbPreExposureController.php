<?php

namespace App\Http\Controllers\API\V1\AnimalBite;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AnimalBite\PatientAbPreExposureRequest;
use App\Http\Resources\API\V1\AnimalBite\PatientAbPreExposureResource;
use App\Models\V1\AnimalBite\PatientAbPreExposure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient AB
 *
 * APIs for managing AB pre exposure
 *
 * @subgroup Patient AB pre exposure.
 *
 * @subgroupDescription List of Patient AB pre exposure.
 */
class PatientAbPreExposureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\AnimalBite\PatientAbPreExposureResource
     *
     * @apiResourceModel App\Models\V1\AnimalBite\PatientAbPreExposure
     */
    public function index(Request $request): ResourceCollection
    {
        $query = QueryBuilder::for(PatientAbPreExposure::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->with('indicationOption', 'day0Vaccine', 'day0VaccineRoute',
                    'day7Vaccine', 'day7VaccineRoute',
                    'day21Vaccine', 'day21VaccineRoute');

        return PatientAbPreExposureResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\AnimalBite\PatientAbPreExposureResource
     *
     *  @apiResourceModel App\Models\V1\AnimalBite\PatientAbPreExposure
     */
    public function store(PatientAbPreExposureRequest $request): JsonResponse
    {
        $data = PatientAbPreExposure::create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Success'], 201);
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
    public function update(PatientAbPreExposureRequest $request, PatientAbPreExposure $patientAbPreExposure)
    {
        $patientAbPreExposure->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientAbPreExposure $patientAbPreExposure): JsonResponse
    {
        $patientAbPreExposure->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
