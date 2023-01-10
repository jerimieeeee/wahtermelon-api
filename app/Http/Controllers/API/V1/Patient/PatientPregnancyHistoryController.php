<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientPregnancyHistoryRequest;
use App\Http\Resources\API\V1\Patient\PatientPregnancyHistoryResource;
use App\Models\V1\Patient\PatientPregnancyHistory;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Patient History Management
 *
 * APIs for managing Patient History
 * @subgroup Pregnancy History
 * @subgroupDescription Patient Pregnancy History management.
 */
class PatientPregnancyHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string Patient record to view.
     * @queryParam patient_id Identification code of the patient.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $patientPregnancyHistory = QueryBuilder::for(PatientPregnancyHistory::class)
            ->when(isset($request->patient_id), function($q) use($request){
                $q->where('patient_id', $request->patient_id);
            })
            // ->when(isset($request->post_partum_id), function($q) use($request){
            //     $q->where('post_partum_id', $request->post_partum_id);
            // })
            ->with('libPregnancyDeliveryType', 'libPregnancyHistoryAnswer', 'inducedHypertension', 'withFamilyPlanning', 'pregnancyHistoryApplicable');

        if ($perPage === 'all') {
            return PatientPregnancyHistoryResource::collection($patientPregnancyHistory->get());
        }

        return PatientPregnancyHistoryResource::collection($patientPregnancyHistory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientPregnancyHistoryRequest $request)
    {
        $data = PatientPregnancyHistory::updateOrCreate(['patient_id' => $request['patient_id']],$request->validated());
        $data1 = new PatientPregnancyHistoryResource($data);
        return response()->json(['data' => $data1], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PatientPregnancyHistory $patientPregnancyHistory)
    {
        $query = PatientPregnancyHistory::where('id', $patientPregnancyHistory->id);
        $patientPregnancyHistory = QueryBuilder::for($query)
            ->first();
        return new PatientPregnancyHistoryResource($patientPregnancyHistory);
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
