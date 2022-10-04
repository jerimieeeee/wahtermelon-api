<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Models\V1\Consultation\ConsultNotesInitialDx;
use Exception;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $initialdx = $request->input('idx');
            $initialdx_array = [];
            foreach($initialdx as $value){
                $data = ConsultNotesInitialDx::firstOrNew(['notes_id' => $request->input('notes_id'), 'class_id' => $value,]);
                $data->user_id = $request->input('user_id');
                $data->dx_remarks = $request->input('dx_remarks');
                $data->class_id = $value;
            $data->save();
            array_push($initialdx_array, $value);
            }
            ConsultNotesInitialDx::whereNotIn('class_id', $initialdx_array)
            ->where('notes_id', '=', $data->notes_id )
            ->delete();

            return response()->json([
                'status_code' => 200,
                'message' => 'Initial Dx Successfully Saved',
            ]);
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
