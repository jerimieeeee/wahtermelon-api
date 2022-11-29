<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Consultation\ConsultNotesFinalDxRequest;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @authenticated
 * @group Consultation Information Management
 *
 * APIs for managing Patient Consultation Final Dx information
 * @subgroup Patient Consultation Final Dx
 * @subgroupDescription Patient Consultation Final Dx management.
 */
class ConsultNotesFinalDxController extends Controller
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
     * Store a newly created Consultation Final Dx resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Consultation\ConsultNotesFinalDxResource
     * @apiResourceModel App\Models\V1\Consultation\ConsultNotesFinalDx
     * @param ConsultNotesFinalDxRequest $request
     * @return JsonResponse
     */
    public function store(ConsultNotesFinalDxRequest $request) : JsonResponse
    {
        $fdx = $request->input('fdx');
        foreach($fdx as $value){
            ConsultNotesFinalDx::updateOrCreate(['notes_id' => $request->notes_id, 'icd10_code' => $value['icd10_code'], 'fdx_remark' => $value['fdx_remark']],
            ['notes_id' => $request->input('notes_id'),'user_id' => $request->input('user_id')] + $value);
        }

        $patientfdx = ConsultNotesFinalDx::where('notes_id', '=', $request->notes_id)
        ->orderBy('notes_id', 'ASC')
        ->orderBy('id', 'ASC')
        ->orderBy('icd10_code', 'ASC')
        ->get();

        return response()->json([
            'message' => 'Final Dx Successfully Saved',
            'data' => $patientfdx
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ConsultNotesFinalDx::where('notes_id', '=', $id)
        ->orderBy('id', 'asc')
        ->orderBy('notes_id', 'asc')
        ->orderBy('icd10_code', 'asc')
        ->get();
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
        // ConsultNotesFinalDx::findorfail($id)->update($request->all());
        // return response()->json('Consult Notes Final Dx Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ConsultNotesFinalDx::findorfail($id)->delete();
        return response()->json('Final Dx successfully deleted');
    }
}
