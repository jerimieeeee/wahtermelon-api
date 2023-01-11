<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientSocialHistoryRequest;
use App\Http\Resources\API\V1\Patient\PatientSocialHistoryResource;
use App\Models\V1\Patient\PatientSocialHistory;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Patient History Management
 *
 * APIs for managing Patient History
 * @subgroup Social History
 * @subgroupDescription Patient Social History management.
 */
class PatientSocialHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string Patient record to view.
     * @queryParam patient_id Identification code of the patient.
     * @queryParam category category. Example: 1
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Patient\PatientSocialHistoryResource
     * @apiResourceModel App\Models\V1\Patient\PatientSocialHistory paginate=15
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $patientSocialHistory = QueryBuilder::for(PatientSocialHistory::class)
            ->when(isset($request->patient_id), function($q) use($request){
                $q->where('patient_id', $request->patient_id);
            });

        if ($perPage === 'all') {
            return PatientSocialHistoryResource::collection($patientSocialHistory->get());
        }

        return PatientSocialHistoryResource::collection($patientSocialHistory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientSocialHistoryRequest $request)
    {
        $data = PatientSocialHistory::updateOrCreate(['patient_id' => $request['patient_id']],$request->validated());
        $data1 = new PatientSocialHistoryResource($data);
        return response()->json(['data' => $data1], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PatientSocialHistory $patientSocialHistory): PatientSocialHistoryResource
    {
        $query = PatientSocialHistory::where('id', $patientSocialHistory->id);
        $patientSocialHistory = QueryBuilder::for($query)
            ->first();
        return new PatientSocialHistoryResource($patientSocialHistory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
