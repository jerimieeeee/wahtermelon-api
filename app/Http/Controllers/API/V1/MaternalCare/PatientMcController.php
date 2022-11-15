<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\PatientMcRequest;
use App\Http\Resources\API\V1\MaternalCare\PatientMcResource;
use App\Models\V1\MaternalCare\PatientMc;
use App\Services\MaternalCare\MaternalCareRecordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Maternal Care Management
 *
 * APIs for managing maternal care information
 * @subgroup Maternal Care Record
 * @subgroupDescription Maternal care management.
 */
class PatientMcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, MaternalCareRecordService $maternalCareRecordService)
    {
        if($request->type == 'latest')
        {
            $mc = $maternalCareRecordService->getLatestMcRecord($request->all());
            if(!$mc) {
                return response()->json(['message' => 'No existing or pending record.'], 404);
            }

            return new PatientMcResource(PatientMc::find($mc->id)->loadMissing('preRegister', 'postRegister', 'prenatal', 'postpartum'));

        }

        $data = PatientMc::with('preRegister', 'postRegister', 'prenatal', 'postpartum')->get();
        return PatientMcResource::collection($data)->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientMcRequest $request)
    {
        $data = PatientMc::create($request->all());
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PatientMc $mc)
    {
        return new PatientMcResource($mc->loadMissing('preRegister', 'postRegister', 'prenatal', 'postpartum'));
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
