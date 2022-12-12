<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultNotesComplaintRequest;
use App\Http\Resources\API\V1\Consultation\ConsultNotesResource;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesComplaint;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @authenticated
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
        try {
            $complaint = $request->complaints;
            foreach ($complaint as $value) {
                ConsultNotesComplaint::firstOrCreate($request->safe()->except('complaints') + ['complaint_id' => $value]);
            }

            ConsultNotesComplaint::whereNotIn('complaint_id', $complaint)
                ->where('notes_id', $request->safe()->notes_id)
                ->delete();

            return response()->json([
                'message' => 'Complaint Successfully Saved',
            ], 201);

        } catch (Exception $error) {
            return response()->json([
                'Error' => $error,
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
    public function show(ConsultNotes $consult_id): ConsultNotesResource
    {
        ConsultNotes::where('id', $consult_id->id);
        return new ConsultNotesResource($consult_id);
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
