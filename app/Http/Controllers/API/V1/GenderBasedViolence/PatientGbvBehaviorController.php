<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvBehaviorRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvBehaviorResource;
use App\Models\V1\GenderBasedViolence\PatientGbvBehavior;
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
 * @subgroup Patient GBV Behavior
 *
 * @subgroupDescription Patient GBV Behavior Management.
 */
class PatientGbvBehaviorController extends Controller
{
    /**
     * Display a listing of the Patient GBV Behavior resource.
     *
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvBehaviorResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvBehavior
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvBehavior::query()
            ->with(['patientGbv', 'behavior'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvBehavior = QueryBuilder::for($query);

        return PatientGbvBehaviorResource::collection($patientGbvBehavior->get());
    }

    /**
     * Store a newly created Patient GBV Behavior resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvBehaviorResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvBehavior
     */
    public function store(PatientGbvBehaviorRequest $request)
    {
        $data = PatientGbvBehavior::create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Successfully saved'], 201);
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
    public function update(PatientGbvBehaviorRequest $request, PatientGbvBehavior $patientGbvBehavior)
    {
        $patientGbvBehavior->update($request->safe()->only('behavioral_id'));

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
