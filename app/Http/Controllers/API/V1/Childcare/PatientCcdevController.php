<?php

namespace App\Http\Controllers\API\V1\Childcare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\V1\Childcare\PatientCcdev;
use App\Http\Requests\API\V1\Childcare\PatientCcdevRequest;
use App\Http\Resources\API\V1\Childcare\PatientCcdevResource;
use App\Services\Childcare\PatientChildcareService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Childcare Information Management
 *
 * APIs for managing Childcare Patient information
 * @subgroup Childcare Patient
 * @subgroupDescription Childcare Patient management.
 */
class PatientCcdevController extends Controller
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
     * Store a newly created Patient Childcare resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Childcare\PatientCcdevResource
     * @apiResourceModel App\Models\V1\Childcare\PatientCcdev
     * @param PatientCcdevRequest $request
     * @return JsonResponse
     */
    public function store(PatientCcdevRequest $request)
    {
        $data = PatientCcdev::updateOrCreate(['patient_id' => $request->patient_id],$request->all());
        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Childcare\PatientCcdevResource
     * @apiResourceModel App\Models\V1\Childcare\PatientCcdev
     * @param PatientCcdev $patientccdev
     * @return PatientCcdevResource
     */

    public function show(PatientCcdev $patientccdev, PatientChildcareService $ccdevStatus)
    {
        $query = PatientCcdev::where('id', $patientccdev->id)
                ->leftJoinSub($ccdevStatus->get_cpab_status($patientccdev->mothers_id), 'patientccdev', function($join) {
                    $join->on('mothers_id', '=', 'patientccdev.mothersId');
                 });
        $patientccdev = QueryBuilder::for($query)
            ->first();

        return new PatientCcdevResource($patientccdev);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        PatientCcdev::findorfail($id)->update($request->only('nbs_filter'));

        return response()->json([
            'message' => 'Patient Childcare Successfully Saved',
        ], 201);
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
