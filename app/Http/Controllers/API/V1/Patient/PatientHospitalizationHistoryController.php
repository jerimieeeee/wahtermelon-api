<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientHospitalizationHistoryRequest;
use App\Http\Resources\API\V1\Patient\PatientHospitalizationHistoryResource;
use App\Models\V1\Patient\PatientHospitalizationHistory;
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
class PatientHospitalizationHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string Patient record to view.
     * @queryParam patient_id Identification code of the patient.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Patient\PatientHospitalizationHistoryResource
     *
     * @apiResourceModel App\Models\V1\Patient\PatientHospitalizationHistory paginate=15
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $patientHospitalizationHistory = QueryBuilder::for(PatientHospitalizationHistory::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            });

        if ($perPage === 'all') {
            return PatientHospitalizationHistoryResource::collection($patientHospitalizationHistory->get());
        }

        return PatientHospitalizationHistoryResource::collection($patientHospitalizationHistory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created Patient Surgical History resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\Patient\PatientHospitalizationHistoryResource
     *
     * @apiResourceModel App\Models\V1\Patient\PatientHospitalizationHistory
     *
     * @return JsonResponse
     */
    public function store(PatientHospitalizationHistoryRequest $request)
    {
        $data = PatientHospitalizationHistory::create($request->validated());

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
    public function destroy(PatientHospitalizationHistory $patientHospitalizationHistory)
    {
        $patientHospitalizationHistory->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
