<?php

namespace App\Http\Controllers\API\V1\Childcare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\V1\Childcare\PatientCcdev;
use App\Http\Requests\API\V1\Childcare\PatientCcdevRequest;
use App\Http\Resources\API\V1\Childcare\PatientCcdevResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
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
        // $data = PatientCcdev::firstOrCreate($request->all());
        // return response()->json(['data' => $data], 201);

        // $count = DB::table('patient_ccdevs')->distinct('patient_id')->count('patient_id');
        // return $count;
        // $data = PatientCcdev::where('patient_id', $request->patient_id)->get();

        // if($data->count($count)){
        //     // PatientCcdev::update($request->all());
        //     PatientCcdev::where('patient_id', $data->patient_id)->update($request->all());
        //     }else{
        //         PatientCcdev::Create($request->all());
        //     }

        // return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Childcare\PatientCcdevResource
     * @apiResourceModel App\Models\V1\Childcare\PatientCcdev
     * @param PatientCcdev $patientccdev
     * @return PatientCcdevResource
     */

    public function show(PatientCcdev $patientccdev)
    {
        $query = PatientCcdev::where('id', $patientccdev->id);

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
    public function update(PatientCcdevRequest $request, $id)
    {
        PatientCcdev::findorfail($id)->update($request->all());
        return response()->json('Patient Child Care Successfully Updated');
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
