<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultNotesComplaintRequest;
use App\Models\V1\Consultation\ConsultNotesComplaint;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Consultation Chief Complaint Management
 *
 * APIs for managing Patient Consultation Chief Complaint information
 * @subgroup Patient Consultation Chief Complaint
 * @subgroupDescription Patient Consultation Chief Complaint.
 */
class ConsultNotesComplaintController extends Controller
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
     * Store a newly created Consultation Complaints resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Consultation\ConsultNotesComplaintResource
     * @apiResourceModel App\Models\V1\Consultation\ConsultNotesComplaint
     * @param ConsultNotesComplaintRequest $request
     * @return JsonResponse
     */
    public function store(ConsultNotesComplaintRequest $request) : JsonResponse
    {
        try{
            $complaint = $request->input('complaint');
            $complaint_array = [];
            foreach($complaint as $value){
                $data = ConsultNotesComplaint::firstOrNew(['consult_id' => $request->input('consult_id'), 'complaint_id' => $value, 'complaint_date' => now()->format('Y/m/d')]);
                $data->notes_id = $request->input('notes_id');
                $data->consult_id = $request->input('consult_id');
                $data->patient_id = $request->input('patient_id');
                $data->user_id = $request->input('user_id');
                $data->complaint_id = $value;
            $data->save();
            array_push($complaint_array, $value);
            }

            ConsultNotesComplaint::whereNotIn('complaint_id', $complaint_array)
            ->where('consult_id', '=', $data->consult_id )
            ->delete();

            return response()->json([
                'status_code' => 200,
                'message' => 'Complaint Successfully Saved',
            ]);
            }catch(Exception $error) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Complaint Saving Error',
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
        $data = ConsultNotesComplaint::findOrFail($id);
        return response()->json(['data' => $data], 201);
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
        ConsultNotesComplaint::findorfail($id)->update($request->all());
        return response()->json('Consult Notes Complaint Successfully Updated');
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
