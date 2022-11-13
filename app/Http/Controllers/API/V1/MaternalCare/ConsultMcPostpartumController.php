<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\ConsultMcPostpartumRequest;
use App\Models\V1\MaternalCare\ConsultMcPostpartum;
use App\Services\MaternalCare\MaternalCareRecordService;
use Illuminate\Http\Request;

class ConsultMcPostpartumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsultMcPostpartumRequest $request)
    {
        ConsultMcPostpartum::updateOrCreate(['patient_mc_id' => $request->patient_mc_id, 'postpartum_date' => $request->postpartum_date], $request->validatedWithCasts());
        $mc = new MaternalCareRecordService();
        return $mc->updateVisitSequence($request->patient_mc_id, 'ConsultMcPostpartum', 'postpartum_date');
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
