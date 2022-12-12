<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultPeRemarksRequest;
use App\Models\V1\Consultation\ConsultPeRemarks;
use Illuminate\Http\Request;

class ConsultPeRemarksController extends Controller
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
    public function store(ConsultPeRemarksRequest $request)
    {
        $data = ConsultPeRemarks::create($request->all());
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultPeRemarksRequest $request, $id)
    {
        ConsultPeRemarks::findorfail($id)->update($request->only('complaint', 'history', 'physical_exam', 'plan'));
        return response()->json('Consult PE remarks Successfully Updated');
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
