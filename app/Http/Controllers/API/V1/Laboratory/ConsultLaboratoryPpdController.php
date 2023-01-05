<?php

namespace App\Http\Controllers\API\V1\Laboratory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryPpdRequest;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryPpdResource;
use App\Models\V1\Laboratory\ConsultLaboratoryPpd;
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
 * @subgroup PPD Test
 * @subgroupDescription Consult laboratory for PPD Test.
 */
class ConsultLaboratoryPpdController extends Controller
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
     * @apiResourceCollection App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryPpdResource
     * @apiResourceModel App\Models\V1\Laboratory\ConsultLaboratoryPpd paginate=15
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = ConsultLaboratoryPpd::query()
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
            ->with(['findings'])
            ->defaultSort('-laboratory_date')
            ->allowedSorts('laboratory_date');

        if ($perPage == 'all') {
            return ConsultLaboratoryPpdResource::collection($laboratory->get());
        }

        return ConsultLaboratoryPpdResource::collection($laboratory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsultLaboratoryPpdRequest $request
     * @return JsonResponse
     */
    public function store(ConsultLaboratoryPpdRequest $request): JsonResponse
    {
        $data = ConsultLaboratoryPpd::updateOrCreate(['request_id' => $request->safe()->request_id], $request->validated());
        return response()->json(['data' => new ConsultLaboratoryPpdResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param ConsultLaboratoryPpd $ppd
     * @return ConsultLaboratoryPpdResource
     */
    public function show(ConsultLaboratoryPpd $ppd): ConsultLaboratoryPpdResource
    {
        return new ConsultLaboratoryPpdResource($ppd);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConsultLaboratoryPpdRequest $request
     * @param ConsultLaboratoryPpd $ppd
     * @return JsonResponse
     */
    public function update(ConsultLaboratoryPpdRequest $request, ConsultLaboratoryPpd $ppd): JsonResponse
    {
        $ppd->update($request->validated());
        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConsultLaboratoryPpd $ppd
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(ConsultLaboratoryPpd $ppd): JsonResponse
    {
        $ppd->deleteOrFail();
        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
