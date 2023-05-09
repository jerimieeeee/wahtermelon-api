<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvFamilyCompositionRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvFamilyCompositionResource;
use App\Models\V1\GenderBasedViolence\PatientGbvFamilyComposition;
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
 * @subgroup Patient GBV Family Compostion
 *
 * @subgroupDescription Patient GBV Family Composition Management.
 */
class PatientGbvFamilyCompositionController extends Controller
{
    /**
     * Display a listing of the Patient GBV Family Composition resource.
     *
     * @queryParam sort string Sort age of the patient. Example: -age
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvFamilyCompositionResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvFamilyComposition
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvFamilyComposition::query()->with(['patientGbv', 'relation', 'facility'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvFamilyComposition = QueryBuilder::for($query)
            ->defaultSort('-age')
            ->allowedSorts('age');

        return PatientGbvFamilyCompositionResource::collection($patientGbvFamilyComposition->get());
    }

    /**
     * Store a newly created Patient GBV Family Composition resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvFamilyCompositionResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvFamilyComposition
     */
    public function store(PatientGbvFamilyCompositionRequest $request)
    {
        $data = PatientGbvFamilyComposition::create($request->validated());

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
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(PatientGbvFamilyCompositionRequest $request, PatientGbvFamilyComposition $patientGbvFamilyComposition)
    {
        $patientGbvFamilyComposition->update($request->validated());

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
