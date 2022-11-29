<?php

namespace App\Http\Controllers\API\V1\Childcare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Childcare\ConsultCcdevServiceRequest;
use App\Http\Requests\API\V1\Childcare\ConsultCcdevServiceUpdateRequest;
use App\Http\Resources\API\V1\Childcare\ConsultCcdevResource;
use App\Http\Resources\API\V1\Childcare\ConsultCcdevServiceResource;
use App\Models\V1\Childcare\ConsultCcdev;
use App\Models\V1\Childcare\ConsultCcdevService;
use App\Models\V1\Libraries\LibCcdevService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Childcare Service Management
 *
 * APIs for managing Childcare Service information
 * @subgroup Childcare Service
 * @subgroupDescription Childcare Service management.
 */

class ConsultCcdevServiceController extends Controller
{
    /**
     * Display a listing of the Childcare Service resource.
     *
     * @queryParam sort string Sort service_id, service_date, of the patient. Example: -service_id
     * @queryParam patient_id string Patient to view.
     * @apiResourceCollection App\Http\Resources\API\V1\Childcare\ConsultCcdevServiceResource
     * @apiResourceModel App\Models\V1\Childcare\ConsultCcdevService
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $query = ConsultCcdevService::query()->with(['services:service_id,service_name,service_cat'])
                ->when(isset($request->patient_id), function($query) use($request){
                    return $query->wherePatientId($request->patient_id);
                });
        $services = QueryBuilder::for($query)
                ->defaultSort('-service_date', '-service_id')
                ->allowedSorts(['service_date', 'service_id']);

        return ConsultCcdevServiceResource::collection($services->get());
    }

    /**
     * Store a newly created Childcare Service resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Childcare\ConsultCcdevServiceResource
     * @apiResourceModel App\Models\V1\Childcare\ConsultCcdevService
     * @param ConsultCcdevServiceRequest $request
     * @return JsonResponse
     */
    public function store(ConsultCcdevServiceRequest $request): JsonResponse
    {

        $service = $request->input('services');
        $service_array = [];
        foreach($service as $value){
            ConsultCcdevService::updateOrCreate(['patient_id' => $request->patient_id, 'service_id' => $value['service_id']],
            ['patient_id' => $request->input('patient_id'),'user_id' => $request->input('user_id')] + $value);
        }

        // ConsultCcdevService::with(['services:service_id,service_name,service_cat'])
        // ->whereNotIn('service_id', $service)
        // ->where('service_cat', '=', $s->consult_id )
        // ->delete();

        ConsultCcdevService::whereNotIn('service_id', $service_array)
        ->whereHas('services', function($q){
            $q->where('service_cat', '=', 'Y');
        })->delete();

        $ccdevservices = ConsultCcdevService::where('patient_id', '=', $request->patient_id)->orderBy('service_date', 'ASC')->get();

        return response()->json([
            'message' => 'Services Successfully Saved',
            'data' => $ccdevservices
        ], 201);

        // $service = $request->input('service');
        // foreach($service as $value){
        //    ConsultCcdevService::updateOrCreate(['patient_id' => $request->patient_id, 'service_id' => $value['service_id'], 'service_date' => $value['service_date']],
        //     ['patient_id' => $request->input('patient_id'),'user_id' => $request->input('user_id')] + $value);
        // }

        // $patientservice = ConsultCcdevService::where('patient_id', '=', $request->patient_id)->orderBy('service_date', 'ASC')->get();

        // return response()->json([
        //     'message' => 'Services Successfully Saved',
        //     'data' => $patientservice
        // ], 201);
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
    public function update(ConsultCcdevServiceUpdateRequest $request, $id)
    {
        ConsultCcdevService::findorfail($id)->update($request->all());
        return response()->json('Service Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        ConsultCcdevService::findorfail($id)->forceDelete($request->all());
        return response()->json('Service Successfully Deleted');
    }
}
