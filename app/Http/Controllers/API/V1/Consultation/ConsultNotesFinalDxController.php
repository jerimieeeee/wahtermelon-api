<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultNotesFinalDxRequest;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * @group Consultation Information Management
 *
 * APIs for managing Patient Consultation Final Dx information
 *
 * @subgroup Patient Consultation Final Dx
 *
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
     *
     * @apiResource 201 App\Http\Resources\API\V1\Consultation\ConsultNotesFinalDxResource
     *
     * @apiResourceModel App\Models\V1\Consultation\ConsultNotesFinalDx
     */
    public function store(ConsultNotesFinalDxRequest $request): JsonResponse
    {
        try {
            $finaldx = $request->final_diagnosis;
            foreach ($finaldx as $value) {
                ConsultNotesFinalDx::firstOrCreate($request->safe()->except('final_diagnosis') + ['icd10_code' => $value]);
            }

            ConsultNotesFinalDx::query()
                ->whereNotin('icd10_code', $finaldx)
                ->where('notes_id', $request->safe()->notes_id)
                ->delete();

            return response()->json([
                'message' => 'Final Dx Successfully Saved',
            ], 201);
        } catch (Exception $error) {
            return response()->json([
                'Error' => $error,
                'status_code' => 500,
                'message' => 'Final Dx Saving Error',
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
        return ConsultNotesFinalDx::where('notes_id', '=', $id)
            ->orderBy('id', 'asc')
            ->orderBy('notes_id', 'asc')
            ->orderBy('icd10_code', 'asc')
            ->get();
    }

    /**
     * Update the specified resource in storage.
     *
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
