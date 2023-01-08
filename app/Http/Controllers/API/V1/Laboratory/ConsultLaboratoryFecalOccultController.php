<?php

namespace App\Http\Controllers\API\V1\Laboratory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryFecalOccultRequest;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryFecalOcccultResource;
use App\Models\V1\Laboratory\ConsultLaboratoryFecalOccult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class ConsultLaboratoryFecalOccultController extends Controller
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
     * @apiResourceCollection App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryFecalOccultResource
     * @apiResourceModel App\Models\V1\Laboratory\ConsultLaboratoryFecalOccult paginate=15
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = ConsultLaboratoryFecalOccult::query()
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
            return ConsultLaboratoryFecalOcccultResource::collection($laboratory->get());
        }

        return ConsultLaboratoryFecalOcccultResource::collection($laboratory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsultLaboratoryFecalOccultRequest $request
     * @return JsonResponse
     */
    public function store(ConsultLaboratoryFecalOccultRequest $request): JsonResponse
    {
        $data = ConsultLaboratoryFecalOccult::updateOrCreate(['request_id' => $request->safe()->request_id], $request->validated());
        return response()->json(['data' => new ConsultLaboratoryFecalOcccultResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param ConsultLaboratoryFecalOccult $fecalOccult
     * @return ConsultLaboratoryFecalOcccultResource
     */
    public function show(ConsultLaboratoryFecalOccult $fecalOccult): ConsultLaboratoryFecalOcccultResource
    {
        return new ConsultLaboratoryFecalOcccultResource($fecalOccult);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConsultLaboratoryFecalOccultRequest $request
     * @param ConsultLaboratoryFecalOccult $fecalOccult
     * @return JsonResponse
     */
    public function update(ConsultLaboratoryFecalOccultRequest $request, ConsultLaboratoryFecalOccult $fecalOccult): JsonResponse
    {
        $fecalOccult->update($request->validated());
        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConsultLaboratoryFecalOccult $fecalOccult
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(ConsultLaboratoryFecalOccult $fecalOccult): JsonResponse
    {
        $fecalOccult->deleteOrFail();
        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
