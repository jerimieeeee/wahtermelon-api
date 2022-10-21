<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Models\V1\Consultation\ConsultNotesPe;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Consultation\ConsultNotesPeRequest;
use Illuminate\Http\JsonResponse;

/**
 * @group Consultation Information Management
 *
 * APIs for managing Patient Consultation Physical Exam information
 * @subgroup Patient Patient Consultation Physical Exam
 * @subgroupDescription Patient Consultation Physical Exam.
 */
class ConsultNotesPeController extends Controller
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
     * Store a newly created Consultation Physical Exam resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Consultation\ConsultNotesPeResource
     * @apiResourceModel App\Models\V1\Consultation\ConsultNotesPe
     * @param ConsultNotesPeRequest $request
     * @return JsonResponse
     */
    public function store(ConsultNotesPe $request) : JsonResponse
    {
        $data = ConsultNotesPe::create($request->all());
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ConsultNotesPe::findOrFail($id);
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
        ConsultNotesPe::findorfail($id)->update($request->all());
        return response()->json('Consult Notes PE Successfully Updated');
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
