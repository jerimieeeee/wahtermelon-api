<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\PatientMcRequest;
use App\Http\Resources\API\V1\MaternalCare\PatientMcResource;
use App\Models\V1\MaternalCare\PatientMc;
use App\Services\MaternalCare\MaternalCareRecordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Maternal Care Management
 *
 * APIs for managing maternal care information
 *
 * @subgroup Maternal Care Record
 *
 * @subgroupDescription Maternal care management.
 */
class PatientMcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam type string Type of query. To view all records of patient: e.g. type=all. To view the latest record of patient: e.g. type=latest. Example: latest
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\MaternalCare\PatientMcResource
     *
     * @apiResourceModel App\Models\V1\MaternalCare\PatientMc
     */
    public function index(Request $request, MaternalCareRecordService $maternalCareRecordService): JsonResponse|PatientMcResource|ResourceCollection
    {
        if ($request->type == 'latest') {
            $mc = $maternalCareRecordService->getLatestMcRecord($request->all());
            if (! $mc) {
                return response()->json(['message' => 'No existing or pending record.'], 200);
            }
            $query = PatientMc::where('id', $mc->id);
            $patientMc = QueryBuilder::for($query)
                ->with('preRegister', 'postRegister', 'prenatal', 'postpartum', 'riskFactor')
                ->first();

            return  new PatientMcResource($patientMc);
        }

        if ($request->type == 'all') {
            $query = PatientMc::where('patient_id', $request->patient_id);
            $patientMc = QueryBuilder::for($query)
                ->with('preRegister', 'postRegister', 'prenatal', 'postpartum', 'riskFactor')
                ->get();

            return PatientMcResource::collection($patientMc->sortByDesc('preRegister.pre_registration_date')->sortBy('postRegister.post_registration_date'));
        }

        $data = PatientMc::with('preRegister', 'postRegister', 'prenatal', 'postpartum', 'riskFactor')->get();

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
        return new PatientMcResource($mc->loadMissing('preRegister', 'postRegister', 'prenatal', 'postpartum', 'riskFactor'));
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
