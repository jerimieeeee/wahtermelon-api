<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\ConsultMcServiceRequest;
use App\Http\Resources\API\V1\MaternalCare\ConsultMcServiceResource;
use App\Models\V1\MaternalCare\ConsultMcService;
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
 * @subgroup Services
 *
 * @subgroupDescription Service management.
 */
class ConsultMcServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam filter[patient_mc_id] string Filter by patient_mc_id.
     * @queryParam filter[service_id] string Filter by service_id.
     * @queryParam filter[visit_status] string Filter by visit_status e.g. Prenatal or Postpartum. Example: Prenatal
     *
     * @apiResourceCollection App\Http\Resources\API\V1\MaternalCare\ConsultMcServiceResource
     *
     * @apiResourceModel App\Models\V1\MaternalCare\ConsultMcService
     */
    public function index(Request $request): ResourceCollection
    {
        $query = ConsultMcService::query();
        $service = QueryBuilder::for($query)
            ->with('service')
            ->allowedFilters(['patient_mc_id', 'service_id', 'visit_status'])
            ->get();

        return ConsultMcServiceResource::collection($service);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\MaternalCare\ConsultMcServiceResource
     *
     * @apiResourceModel App\Models\V1\MaternalCare\ConsultMcService
     */
    public function store(ConsultMcServiceRequest $request): JsonResponse
    {
        $data = ConsultMcService::updateOrCreate(
            [
                'patient_mc_id' => $request->safe()->patient_mc_id,
                'service_id' => $request->safe()->service_id,
                'service_date' => $request->safe()->service_date,
            ],
            $request->validated()
        );

        return response()->json(['data' => $data, 'status' => 'Success'], 201);
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
     */
    public function update(ConsultMcServiceRequest $request, ConsultMcService $mcService): JsonResponse
    {
        $mcService->update($request->validated());

        return response()->json(['data' => $mcService, 'status' => 'Success'], 200);
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
