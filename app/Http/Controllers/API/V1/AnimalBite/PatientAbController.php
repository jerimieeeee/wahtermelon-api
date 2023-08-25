<?php

namespace App\Http\Controllers\API\V1\AnimalBite;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AnimalBite\PatientAbRequest;
use App\Http\Requests\API\V1\AnimalBite\PatientAbUpdateRequest;
use App\Http\Resources\API\V1\AnimalBite\PatientAbResource;
use App\Models\V1\AnimalBite\PatientAb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient Animal Bite
 *
 * APIs for managing ab case
 *
 * @subgroup Patient AB Case.
 *
 * @subgroupDescription List of Patient AB Case.
 */
class PatientAbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort consult_date. Add hyphen (-) to descend the list: e.g. consult_date. Example: -consult_date
     * @queryParam patient_id string Patient to view.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\AnimalBite\PatientAbResource
     *
     * @apiResourceModel App\Models\V1\AnimalBite\PatientAb
     */
    public function index(Request $request)
    {
        // $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = QueryBuilder::for(PatientAb::class)
        ->when(isset($request->patient_id), function ($q) use ($request) {
            $q->where('patient_id', $request->patient_id);
        })
        ->with(['abExposure',
                'abPostExposure',
                'treatmentOutcome'])
        ->defaultSort('-consult_date')
        ->allowedSorts('consult_date');

        return PatientAbResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAddition status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\AnimalBite\PatientAbResource
     *
     * @apiResourceModel App\Models\V1\AnimalBite\PatientAb
     */
    public function store(PatientAbRequest $request): JsonResponse
    {
        $data = DB::transaction(function () use ($request) {
            $data = PatientAb::create($request->validated());

            return $data->abExposure()->create($request->validated());
        });

        $query = QueryBuilder::for(PatientAb::class)
            ->where('id', $data->patient_ab_id)
            ->with(['abExposure', 'abPostExposure','treatmentOutcome']);

        return response()->json(['data' => PatientAbResource::collection($query->get()), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\AnimalBite\PatientAbResource
     *
     * @apiResourceModel App\Models\V1\AnimalBite\PatientAb
     */
    public function show(PatientAb $patientAb)
    {
        $query = PatientAb::where('id', $patientAb->id);
        $patientAb = QueryBuilder::for($query)
            ->with('abExposure')
            ->first();

        return new PatientAb($patientAb);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientAbUpdateRequest $request, PatientAb $patientAb)
    {
        $patientAb->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
