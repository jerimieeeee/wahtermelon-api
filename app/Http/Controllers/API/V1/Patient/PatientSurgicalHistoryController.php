<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientSurgicalHistoryRequest;
use App\Http\Resources\API\V1\Patient\PatientSurgicalHistoryResource;
use App\Models\V1\Patient\PatientSurgicalHistory;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient History Management
 *
 * APIs for managing Patient History
 *
 * @subgroup Surgical History
 *
 * @subgroupDescription Patient Surgical History management.
 */
class PatientSurgicalHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string Patient record to view.
     * @queryParam patient_id Identification code of the patient.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Patient\PatientSurgicalHistoryResource
     *
     * @apiResourceModel App\Models\V1\Patient\PatientSurgicalHistory paginate=15
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $patientSurgicalHistory = QueryBuilder::for(PatientSurgicalHistory::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            });

        if ($perPage === 'all') {
            return PatientSurgicalHistoryResource::collection($patientSurgicalHistory->get());
        }

        return PatientSurgicalHistoryResource::collection($patientSurgicalHistory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created Patient Surgical History resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\Patient\PatientSurgicalHistoryResource
     *
     * @apiResourceModel App\Models\V1\Patient\PatientSurgicalHistory
     *
     * @return JsonResponse
     */
    public function store(PatientSurgicalHistoryRequest $request)
    {
        $data = PatientSurgicalHistory::create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function destroy(PatientSurgicalHistory $patientSurgicalHistory)
    {
        $patientSurgicalHistory->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
