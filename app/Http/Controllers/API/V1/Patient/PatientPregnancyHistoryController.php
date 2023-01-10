<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
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
            ->when(isset($request->post_partum_id), function($q) use($request){
                $q->where('post_partum_id', $request->post_partum_id);
            })
            ->with('postPartum', 'libPregnancyDeliveryType', 'libPregnancyHistoryAnswer', 'inducedHypertension', 'withFamilyPlanning', 'pregnancyHistoryApplicable');

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
    public function store(Request $request)
    {
        $data = DB::transaction(function () use($request) {
            $data = PatientNcd::create(['date_enrolled' => $request->assessment_date, 'patient_id' => $request->patient_id]);
            return $data->riskAssessment()->create($request->validatedWithCasts());
        });

        return response()->json(['data' => $data], 201);
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
