<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Models\V1\Consultation\ConsultNotes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Consultation Information Management
 *
 * APIs for managing Patient Consultation Notes information
 * @subgroup Patient Consultation Notes
 * @subgroupDescription Patient Consultation Notes management.
 */
class ConsultNotesController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsultNotes $request) : JsonResponse
    {
        $data = ConsultNotes::create($request->all());
        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ConsultNotes::findOrFail($id);
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
        ConsultNotes::findorfail($id)->update($request->all());
        return response()->json('Consult Notes Successfully Updated');
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
