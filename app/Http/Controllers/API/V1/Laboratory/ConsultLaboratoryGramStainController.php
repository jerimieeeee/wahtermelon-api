<?php

namespace App\Http\Controllers\API\V1\Laboratory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryChestXrayRequest;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryGramStainRequest;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryCbcResource;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryGramStainResource;
use App\Models\V1\Laboratory\ConsultLaboratoryCbc;
use App\Models\V1\Laboratory\ConsultLaboratoryChestXray;
use App\Models\V1\Laboratory\ConsultLaboratoryGramStain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

/**
 * @authenticated
 * @group Laboratory Management
 *
 * APIs for managing laboratories
 * @subgroup Gram Stain
 * @subgroupDescription Consult laboratory for gram stain.
 */
class ConsultLaboratoryGramStainController extends Controller
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
     * @apiResourceCollection App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryGramStainResource
     * @apiResourceModel App\Models\V1\Laboratory\ConsultLaboratoryGramStain paginate=15
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = ConsultLaboratoryGramStain::query()
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
            ->with(['user'])
            ->defaultSort('-laboratory_date')
            ->allowedSorts('laboratory_date');

        if ($perPage == 'all') {
            return ConsultLaboratoryGramStainResource::collection($laboratory->get());
        }

        return ConsultLaboratoryGramStainResource::collection($laboratory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsultLaboratoryGramStainRequest $request
     * @return JsonResponse
     */
    public function store(ConsultLaboratoryGramStainRequest $request): JsonResponse
    {
        $data = ConsultLaboratoryGramStain::updateOrCreate(['request_id' => $request->safe()->request_id], $request->validated());
        return response()->json(['data' => new ConsultLaboratoryGramStainResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param ConsultLaboratoryGramStain $gramStain
     * @return ConsultLaboratoryGramStainResource
     */
    public function show(ConsultLaboratoryGramStain $gramStain): ConsultLaboratoryGramStainResource
    {
        return new ConsultLaboratoryGramStainResource($gramStain);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConsultLaboratoryGramStainRequest $request
     * @param ConsultLaboratoryGramStain $gramStain
     * @return JsonResponse
     */
    public function update(ConsultLaboratoryGramStainRequest $request, ConsultLaboratoryGramStain $gramStain): JsonResponse
    {
        $gramStain->update($request->validated());
        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConsultLaboratoryGramStain $gramStain
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(ConsultLaboratoryGramStain $gramStain): JsonResponse
    {
        $gramStain->deleteOrFail();
        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
