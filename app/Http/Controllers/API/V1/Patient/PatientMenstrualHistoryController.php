<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientMenstrualHistoryRequest;
use App\Http\Resources\API\V1\Patient\PatientMenstrualHistoryResource;
use App\Models\V1\Patient\PatientMenstrualHistory;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient History Management
 *
 * APIs for managing Patient History
 *
 * @subgroup Menstrual History
 *
 * @subgroupDescription Patient Menstrual History management.
 */
class PatientMenstrualHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string Patient record to view.
     * @queryParam patient_id Identification code of the patient.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string Patient record to view.
     * @queryParam patient_id Identification code of the patient.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Patient\PatientMenstrualHistoryResource
     *
     * @apiResourceModel App\Models\V1\Patient\PatientMenstrualHistory paginate=15
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $patientMenstrualHistory = QueryBuilder::for(PatientMenstrualHistory::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->with('libFpMethod');

        if ($perPage === 'all') {
            return PatientMenstrualHistoryResource::collection($patientMenstrualHistory->get());
        }

        return PatientMenstrualHistoryResource::collection($patientMenstrualHistory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientMenstrualHistoryRequest $request)
    {
        $data = PatientMenstrualHistory::updateOrCreate(['patient_id' => $request['patient_id']], $request->validated());
        $data1 = new PatientMenstrualHistoryResource($data);

        return response()->json(['data' => $data1], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PatientMenstrualHistory $patientMenstrualHistory): PatientMenstrualHistoryResource
    {
        $query = PatientMenstrualHistory::where('id', $patientMenstrualHistory->id);
        $patientMenstrualHistory = QueryBuilder::for($query)
            ->first();

        return new PatientMenstrualHistoryResource($patientMenstrualHistory);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
