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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $patientHistory = QueryBuilder::for(PatientHistory::class)
            ->when(isset($request->patient_id), function($q) use($request){
                $q->where('patient_id', $request->patient_id);
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
        return DB::transaction(function () use($request) {

            $data = PatientHistory::firstOrCreate($request->validated());

            $medical_history_id = $request->medical_history_id;

            PatientHistory::query()
                ->where('patient_id', $request->safe()->patient_id)
                ->delete();

                if (isset($request->medical_history_id)) {
                    foreach ($medical_history_id as $value) {
                        PatientHistory::where('patient_id', $data->patient_id)->firstOrCreate(['patient_id' => $data->patient_id, 'medical_history_id' => $value]);
                    }
                }

            return response()->json([
                'message' => 'Successfully Saved',
            ], 201);
        });
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
