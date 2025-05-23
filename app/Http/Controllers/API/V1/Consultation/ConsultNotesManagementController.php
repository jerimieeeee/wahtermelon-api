<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultNotesManagementRequest;
use App\Models\V1\Consultation\ConsultNotesManagement;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * @group Consultation Information Management
 *
 * APIs for managing Patient Consultation Management information
 *
 * @subgroup Patient Consultation Management
 *
 * @subgroupDescription Patient Consultation Management.
 */
class ConsultNotesManagementController extends Controller
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
     * @return JsonResponse
     */
    public function store(ConsultNotesManagementRequest $request)
    {
        $management = $request->input('management');
        ConsultNotesManagement::query()
            ->where('notes_id', $request->safe()->notes_id)
            ->delete();

        if (isset($request->management)) {
            foreach ($management as $value) {
                ConsultNotesManagement::create(['notes_id' => $request->input('notes_id'), 'patient_id' => $request->input('patient_id')] + $value);
            }
        }

        return response()->json([
            'message' => 'consult management successfully Saved',
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
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
