<?php

namespace App\Http\Controllers\API\V1\AnimalBite;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AnimalBite\PatientAbExposureRequest;
use App\Http\Resources\API\V1\AnimalBite\PatientAbExposureResource;
use App\Models\V1\AnimalBite\PatientAbExposure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient AB
 *
 * APIs for managing ab exposure
 *
 * @subgroup Patient AB exposure.
 *
 * @subgroupDescription List of Patient AB exposure.
 */
class PatientAbExposureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = QueryBuilder::for(PatientAbExposure::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            });

        return PatientAbExposureResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
    public function update(PatientAbExposureRequest $request, PatientAbExposure $patientAbExposure)
    {
        $patientAbExposure->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
