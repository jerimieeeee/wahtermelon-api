<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvResource;
use App\Models\V1\GenderBasedViolence\PatientGbv;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient GBV Management
 *
 * APIs for managing Patient GBV information
 *
 * @subgroup Patient GBV
 *
 * @subgroupDescription Patient GBV Management.
 */
class PatientGbvController extends Controller
{
    /**
     * Display a listing of the Patient GBV resource.
     *
     * @queryParam sort string Sort case_date, of the patient gbv. Example: -case_date
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbv
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbv::query()
            ->with(['relation', 'facility', 'livingArrangement', 'presentArrangement', 'outcomeVerdict', 'outcomeResult', 'outcomeReason'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvFamilyComposition = QueryBuilder::for($query)
            ->defaultSort('-case_date')
            ->allowedSorts('case_date');

        return PatientGbvResource::collection($patientGbvFamilyComposition->get());
    }

    /**
     * Store a newly created Consult resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbv
     */
    public function store(PatientGbvRequest $request): JsonResponse
    {
        $data = PatientGbv::create($request->validated());

        return response()->json(['data' => $data], 201);
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
    public function update(PatientGbvRequest $request, PatientGbv $patientGbv)
    {
        $patientGbv->update($request->validated());

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
