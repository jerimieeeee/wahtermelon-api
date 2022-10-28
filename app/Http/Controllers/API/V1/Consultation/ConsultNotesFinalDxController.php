<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Consultation\ConsultNotesFinalDxRequest;
use Exception;
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
    public function store(ConsultNotesFinalDxRequest $request) : JsonResponse
    {
        try{
            $fdx = $request->input('fdx');
            $fdx_array = [];
            foreach($fdx as $key => $value){
                $data = ConsultNotesFinalDx::firstOrNew(['notes_id' => $request->input('notes_id'), 'icd10_code' => $value]);
                $data->user_id = $request->input('user_id');
                $data->icd10_code = $value;
                $data->fdx_remark = $request->input('fdx_remark')[$key] == null ? null : ($request->input('fdx_remark')[$key]);
            $data->save();
            array_push($fdx_array, $value);
            }
            ConsultNotesFinalDx::whereNotIn('icd10_code', $fdx_array)
            ->where('notes_id', '=', $data->notes_id )
            ->delete();

            return response()->json([
                'message' => 'Final Dx Successfully Saved',
            ], 201);

            }catch(Exception $error) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Final Dx Saving Error',
                    'error' => $error,
                ]);
            }
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
