<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\ConsultMcRiskRequest;
use App\Http\Resources\API\V1\MaternalCare\ConsultMcRiskResource;
use App\Models\V1\MaternalCare\ConsultMcRisk;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Maternal Care Management
 *
 * APIs for managing maternal care information
 *
 * @subgroup Risk Factor
 *
 * @subgroupDescription Risk factor management.
 */
class ConsultMcRiskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_mc_id string Patient record to view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ConsultMcRisk::query();
        $consultRisk = QueryBuilder::for($query)
            ->when(isset($request->patient_mc_id), function ($q) use ($request) {
                $q->wherePatientMcId($request->patient_mc_id);
            })
            ->get();

        return ConsultMcRiskResource::collection($consultRisk);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ConsultMcRiskRequest $request)
    {
        ConsultMcRisk::updateOrCreate(['patient_mc_id' => $request->patient_mc_id, 'risk_id' => $request->risk_id], $request->validated());

        return ConsultMcRiskResource::collection(ConsultMcRisk::where('patient_mc_id', $request->patient_mc_id)->get());
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
     * @return Response
     */
    public function update(ConsultMcRiskRequest $request, ConsultMcRisk $mcRisk)
    {
        $mcRisk->update($request->validated());

        return ConsultMcRiskResource::collection(ConsultMcRisk::where('patient_mc_id', $request->patient_mc_id)->get());
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
