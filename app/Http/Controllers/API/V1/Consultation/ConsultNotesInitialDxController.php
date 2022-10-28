<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Models\V1\Consultation\ConsultNotesInitialDx;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Consultation\ConsultNotesInitialDxRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * @group Consultation Information Management
 *
 * APIs for managing Patient Consultation Final Dx information
 * @subgroup Patient Consultation Final Dx
 * @subgroupDescription Patient Consultation Final Dx management.
 */
class ConsultNotesInitialDxController extends Controller
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
     * Store a newly created Consultation Initial Dx resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Consultation\ConsultNotesInitialDxResource
     * @apiResourceModel App\Models\V1\Consultation\ConsultNotesInitialDx
     * @param ConsultNotesInitialDxRequest $request
     * @return JsonResponse
     */
    public function store(ConsultNotesInitialDxRequest $request) : JsonResponse
    {
        try{
            $idx = $request->input('idx');
            $idx_array = [];
            foreach($idx as $key => $value){
                $data = ConsultNotesInitialDx::firstOrNew(['notes_id' => $request->input('notes_id'), 'class_id' => $value]);
                $data->user_id = $request->input('user_id');
                $data->class_id = $value;
                $data->idx_remark = $request->input('idx_remark')[$key] == null ? null : ($request->input('idx_remark')[$key]);
            $data->save();
            array_push($idx_array, $value);
            }
            ConsultNotesInitialDx::whereNotIn('class_id', $idx_array)
            ->where('notes_id', '=', $data->notes_id )
            ->delete();

            return response()->json([
                'message' => 'Initial Dx Successfully Saved',
            ], 201);

            }catch(Exception $error) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Initial Dx Saving Error',
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
        $data = ConsultNotesInitialDx::findOrFail($id);
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
        ConsultNotesInitialDx::findorfail($id)->update($request->all());
        return response()->json('Consult Notes Initial Dx Successfully Updated');
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
