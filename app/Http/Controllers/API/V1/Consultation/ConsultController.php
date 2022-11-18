<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultRequest;
use App\Http\Resources\API\V1\Childcare\ConsultCcdevResource;
use App\Http\Resources\API\V1\Consultation\ConsultResource;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

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
     * @queryParam patient_id Identification code of the patient.
     * @queryParam pt_group Patient group. Example: cn
     * @queryParam consult_done Consultation Status. Example: 1
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Consult::query()
            ->when(isset($request->pt_group), function($q) use($request){
                $q->where('pt_group', $request->pt_group);
            })
            ->when(isset($request->patient_id), function($q) use($request){
                $q->where('patient_id', '=', $request->patient_id);
            })
            ->where('consult_done', '=', $request->consult_done ?? 0)
            ->get();


        return ConsultResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsultRequest $request)
    {
        $request['consult_done'] = 0;
        $data = Consult::query()
        ->when(request('pt_group') == 'cn', function ($q) use($request){
            return $q->create($request->validated())->consult_notes()->create($request->validated());
        })
        ->when(request('pt_group') != 'cn', function ($q) use($request){
            return $q->create($request->except(['physician_id', 'is_pregnant']));
        });

        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     * @queryParam pt_group Patient group. Example: cn
     * @queryParam consult_done Consultation Status. Example: 1
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Consult $consult, Request $request)
    {
        $query = Consult::where('patient_id', $consult->patient_id)
            ->when(isset($request->pt_group), function($q) use($request){
                $q->where('pt_group', $request->pt_group);
            })
        ->where('consult_done', '=', $request->consult_done ?? 0)
        ->get();


        return ConsultResource::collection($query);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultRequest $request, $id)
    {
        Consult::findorfail($id)->update($request->only(['physician_id', 'consult_done', 'is_pregnant']));
        $data = Consult::findorfail($id);
        return response()->json(['data' => $data], 201);
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
