<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientHistoryRequest;
use App\Http\Resources\API\V1\Patient\PatientHistoryResource;
use App\Models\V1\Patient\PatientHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Patient History Management
 *
 * APIs for managing Patient History information
 * @subgroup Patient History
 * @subgroupDescription Patient History management.
 */
class PatientHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string Patient record to view.
     * @queryParam patient_id Identification code of the patient.
     * @queryParam category category. Example: 1
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $patientHistory = QueryBuilder::for(PatientHistory::class)
            ->when(isset($request->patient_id), function($q) use($request){
                $q->where('patient_id', $request->patient_id);
            })
            ->when(isset($request->category), function($q) use($request){
                $q->where('category', $request->category);
            })
            ->with('libmedicalHistory', 'libmedicalHistoryCategory');

        if ($perPage === 'all') {
            return PatientHistoryResource::collection($patientHistory->get());
        }

        return PatientHistoryResource::collection($patientHistory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientHistoryRequest $request)
    {
            $medical_history = $request->input('medical_history');
            PatientHistory::query()
                ->where('patient_id', $request->safe()->patient_id)
                ->where('category', $medical_history[0]['category'])
                ->delete();

                if (isset($request->medical_history)) {
                    foreach($medical_history as $value){
                        PatientHistory::create(['patient_id' => $request->input('patient_id')] + $value);
                    }
                }

            return response()->json([
                'message' => 'Patient History Successfully Saved',
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Patient\PatientHistoryResource
     * @apiResourceModel App\Models\V1\Patient\PatientHistory
     * @param PatientHistory $patientHistory
     * @return PatientHistoryResource
     */
    public function show(PatientHistory $patientHistory): PatientHistoryResource
    {
        $query = PatientHistory::where('id', $patientHistory->id);
        $patientHistory = QueryBuilder::for($query)
            ->first();
        return new PatientHistoryResource($patientHistory);
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
