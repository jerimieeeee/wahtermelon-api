<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultPeRemarksRequest;
use App\Models\V1\Consultation\ConsultPeRemarks;
use Illuminate\Http\Request;

/**
 * @authenticated
 * @group Consultation Information Management
 *
 * APIs for managing Patient Consultation Notes information
 * @subgroup Patient Consultation Notes
 * @subgroupDescription Patient Consultation Notes management.
 */
class ConsultPeRemarksController extends Controller
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
     * Store a newly created Consultation PE remarks resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Consultation\ConsultPeRemarksResoruce
     * @apiResourceModel App\Models\V1\Consultation\ConsultPeRemarks
     * @param ConsultPeRemarksRequest $request
     * @return JsonResponse
     */
    public function store(ConsultPeRemarksRequest $request)
    {
        $data = ConsultPeRemarks::create($request->all());
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
    public function update(ConsultPeRemarksRequest $request, $id)
    {
        ConsultPeRemarks::findorfail($id)->update($request->except('notes_id', 'patient_id', 'user_id', 'facility_code'));
        return response()->json('Consult PE remarks Successfully Updated');
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
