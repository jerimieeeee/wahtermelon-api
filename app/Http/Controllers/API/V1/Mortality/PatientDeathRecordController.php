<?php

namespace App\Http\Controllers\API\V1\Mortality;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Mortality\PatientDeathRecordRequest;
use App\Http\Resources\API\V1\Mortality\PatientDeathRecordResource;
use App\Models\V1\Mortality\PatientDeathRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient Death Record Information Management
 *
 * APIs for managing Patient Death Record information
 *
 * @subgroup Patient Death Record
 *
 * @subgroupDescription Patient Death Record management.
 */
class PatientDeathRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id Identification code of the patient.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Consultation\ConsultResource
     *
     * @apiResourceModel App\Models\V1\Consultation\Consult paginate=15
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientDeathRecord::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->with(['deathType', 'deathPlace', 'barangay', 'immediateCause', 'antecedentCause', 'underlyingCause']);

        if ($perPage === 'all') {
            return PatientDeathRecordResource::collection($query->get());
        }

        return PatientDeathRecordResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientDeathRecordRequest $request): JsonResponse
    {
        $data = PatientDeathRecord::updateOrCreate(['patient_id' => $request->patient_id], $request->validatedWithCasts());

        return response()->json(['data' => new PatientDeathRecordResource($data), 'status' => 'Success'], 201);
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
