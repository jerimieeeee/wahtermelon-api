<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultRequest;
use App\Http\Resources\API\V1\Consultation\ConsultResource;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Consultation Information Management
 *
 * APIs for managing Patient Consultation information
 * @subgroup Patient Consultation
 * @subgroupDescription Patient Consultation management.
 */
class ConsultController extends Controller
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
    public function store(ConsultRequest $request)
    {


        $data = Consult::query()
        ->when(request('pt_group') == 'cn', function ($q) use($request){
            return $q->create($request->validated())->consult_notes()->create($request->validated());
        })
        ->when(request('pt_group') != 'cn', function ($q) use($request){
            return $q->create($request->validated());
        });

        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Consult $consult_id): ConsultResource
    {
        Consult::where('id', $consult_id->id);
        return new ConsultResource($consult_id);
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
        Consult::findorfail($id)->update($request->all());
        return response()->json('Consult Successfully Updated');
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
