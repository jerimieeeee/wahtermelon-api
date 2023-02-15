<?php

namespace App\Http\Controllers\API\V1\Laboratory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratorySputumRequest;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratorySputumResource;
use App\Models\V1\Laboratory\ConsultLaboratorySputum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

/**
 * @authenticated
 * @group Laboratory Management
 *
 * APIs for managing laboratories
 * @subgroup Sputum Test
 * @subgroupDescription Consult laboratory for Sputum Test.
 */
class ConsultLaboratorySputumController extends Controller
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
     * @apiResourceCollection App\Http\Resources\API\V1\Laboratory\ConsultLaboratorySputumResource
     * @apiResourceModel App\Models\V1\Laboratory\ConsultLaboratorySputum paginate=15
     * @param Request $request
     * @return ResourceCollection
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = ConsultLaboratorySputum::query()
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
            ->with(['findings', 'sputumCollection', 'user'])
            ->defaultSort('-laboratory_date')
            ->allowedSorts('laboratory_date');

        if ($perPage == 'all') {
            return ConsultLaboratorySputumResource::collection($laboratory->get());
        }

        return ConsultLaboratorySputumResource::collection($laboratory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsultLaboratorySputumRequest $request
     * @return JsonResponse
     */
    public function store(ConsultLaboratorySputumRequest $request): JsonResponse
    {
        $data = ConsultLaboratorySputum::updateOrCreate(['request_id' => $request->safe()->request_id], $request->validated());
        return response()->json(['data' => new ConsultLaboratorySputumResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param ConsultLaboratorySputum $sputum
     * @return ConsultLaboratorySputumResource
     */
    public function show(ConsultLaboratorySputum $sputum): ConsultLaboratorySputumResource
    {
        return new ConsultLaboratorySputumResource($sputum);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConsultLaboratorySputumRequest $request
     * @param ConsultLaboratorySputum $sputum
     * @return JsonResponse
     */
    public function update(ConsultLaboratorySputumRequest $request, ConsultLaboratorySputum $sputum): JsonResponse
    {
        $sputum->update($request->validated());
        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConsultLaboratorySputum $sputum
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(ConsultLaboratorySputum $sputum): JsonResponse
    {
        $sputum->deleteOrFail();
        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
