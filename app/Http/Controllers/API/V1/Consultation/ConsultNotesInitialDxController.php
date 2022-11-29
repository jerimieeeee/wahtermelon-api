<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Models\V1\Consultation\ConsultNotesInitialDx;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Consultation\ConsultNotesInitialDxRequest;
use App\Http\Resources\API\V1\Consultation\ConsultNotesInitialDxResource;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * @authenticated
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
            $idx = $request->input('idx');
            foreach($idx as $value){
                ConsultNotesInitialDx::updateOrCreate(['notes_id' => $request->notes_id, 'class_id' => $value['class_id'], 'idx_remark' => $value['idx_remark']],
                ['notes_id' => $request->input('notes_id'),'user_id' => $request->input('user_id')] + $value);
            }

            $patientidx = ConsultNotesInitialDx::where('notes_id', '=', $request->notes_id)
            ->orderBy('notes_id', 'ASC')
            ->orderBy('id', 'ASC')
            ->orderBy('class_id', 'ASC')
            ->get();

            return response()->json([
                'message' => 'Initial Dx Successfully Saved',
                'data' => $patientidx
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
        return ConsultNotesInitialDx::where('notes_id', '=', $id)
        ->orderBy('id', 'asc')
        ->orderBy('notes_id', 'asc')
        ->orderBy('class_id', 'asc')
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
        // ConsultNotesInitialDx::findorfail($id)->update($request->all());
        // return response()->json('Consult Notes Initial Dx Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ConsultNotesInitialDx::findorfail($id)->delete();
        return response()->json('Initial Dx successfully deleted');
    }
}
