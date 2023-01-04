<?php

namespace App\Http\Controllers\API\V1\Laboratory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryChestXrayRequest;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryChestXrayResource;
use App\Models\V1\Laboratory\ConsultLaboratoryChestXray;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Laboratory Management
 *
 * APIs for managing medicines
 * @subgroup Chest X-ray
 * @subgroupDescription Consult laboratory for chest x-ray.
 */
class ConsultLaboratoryChestXrayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort laboratory_date. Add hyphen (-) to descend the list: e.g. laboratory_date. Example: -laboratory_date
     * @queryParam patient_id string Patient to view.
     * @queryParam consult_id string Consult to view.
     * @queryParam request_id string Consult Laboratory id to view.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryChestXrayResource
     * @apiResourceModel App\Models\V1\Laboratory\ConsultLaboratoryChestXray paginate=15
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = ConsultLaboratoryChestXray::query()
            ->when(isset($request->patient_id), function($query) use($request){
                return $query->wherePatientId($request->patient_id);
            })
            ->when(isset($request->consult_id), function($query) use($request){
                return $query->whereConsultId($request->consult_id);
            })
            ->when(isset($request->request_id), function($query) use($request){
                return $query->whereRequestId($request->request_id);
            });
        $laboratory = QueryBuilder::for($query)
            ->with(['findings', 'observation'])
            ->defaultSort('-laboratory_date')
            ->allowedSorts('laboratory_date');

        if ($perPage == 'all') {
            return ConsultLaboratoryChestXrayResource::collection($laboratory->get());
        }

        return ConsultLaboratoryChestXrayResource::collection($laboratory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsultLaboratoryChestXrayRequest $request
     * @return JsonResponse
     */
    public function store(ConsultLaboratoryChestXrayRequest $request): JsonResponse
    {
        $data = ConsultLaboratoryChestXray::updateOrCreate(['request_id' => $request->safe()->request_id], $request->validated());
        return response()->json(['data' => new ConsultLaboratoryChestXrayResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param ConsultLaboratoryChestXray $chestxray
     * @return ConsultLaboratoryCreatinineResource
     */
    public function show(ConsultLaboratoryChestXray $chestxray): ConsultLaboratoryCreatinineResource
    {
        return new ConsultLaboratoryChestXrayResource($chestxray);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConsultLaboratoryChestXrayRequest $request
     * @param ConsultLaboratoryChestXray $chestxray
     * @return JsonResponse
     */
    public function update(ConsultLaboratoryChestXrayRequest $request, ConsultLaboratoryChestXray $chestxray): JsonResponse
    {
        $chestxray->update($request->validated());
        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConsultLaboratoryChestXray $chestxray
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(ConsultLaboratoryChestXray $chestxray): JsonResponse
    {
        $chestxray->deleteOrFail();
        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
