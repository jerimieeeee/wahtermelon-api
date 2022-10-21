<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Consultation\ConsultNotesFinalDxRequest;
use Illuminate\Http\JsonResponse;

/**
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
    public function store(ConsultNotesFinalDx $request) : JsonResponse
    {

        $finaldx = ConsultNotesFinalDx::firstOrNew(['notes_id' => $request['notes_id'], 'icd10_code' => $request['icd10_code']]);
          $finaldx->user_id = $request['user_id'];
          $finaldx->dx_remarks = $request['dx_remarks'];
        $finaldx->save();

        return response()->json([
            'status_code' => 201,
            'message' => 'Final Dx Successfully Saved',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ConsultNotesFinalDx::findOrFail($id);
        return $data;
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
        ConsultNotesFinalDx::find($id)->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'Final Dx Successfully Deleted',
        ]);
    }
}
