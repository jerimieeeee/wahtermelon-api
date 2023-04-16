<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultNotesInitialDxRequest;
use App\Models\V1\Consultation\ConsultNotesInitialDx;
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
     *
     * @apiResource 201 App\Http\Resources\API\V1\Consultation\ConsultNotesInitialDxResource
     *
     * @apiResourceModel App\Models\V1\Consultation\ConsultNotesInitialDx
     */
    public function store(ConsultNotesInitialDxRequest $request): JsonResponse
    {
        try {
            $initialdx = $request->initial_diagnosis;
            foreach ($initialdx as $value) {
                ConsultNotesInitialDx::firstOrCreate(['notes_id' => $request->safe()->notes_id, 'class_id' => $value]);
            }

            ConsultNotesInitialDx::query()
                ->whereNotin('class_id', $initialdx)
                ->where('notes_id', $request->safe()->notes_id)
                ->delete();

            return response()->json([
                'message' => 'Initial Dx Successfully Saved',
            ], 201);
        } catch (Exception $error) {
            return response()->json([
                'Error' => $error,
                'status_code' => 500,
                'message' => 'Initial Dx Saving Error',
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
        return ConsultNotesInitialDx::where('notes_id', '=', $id)
        ->orderBy('id', 'asc')
        ->orderBy('notes_id', 'asc')
        ->orderBy('class_id', 'asc')
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
