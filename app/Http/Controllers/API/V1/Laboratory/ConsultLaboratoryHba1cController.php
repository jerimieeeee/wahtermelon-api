<?php

namespace App\Http\Controllers\API\V1\Laboratory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryHba1cRequest;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryHba1cResource;
use App\Models\V1\Laboratory\ConsultLaboratoryHba1c;
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
 * @subgroup HbA1c
 * @subgroupDescription Consult laboratory for HbA1c.
 */
class ConsultLaboratoryHba1cController extends Controller
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
     * @apiResourceCollection App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryHba1cResource
     * @apiResourceModel App\Models\V1\Laboratory\ConsultLaboratoryHba1c paginate=15
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = ConsultLaboratoryHba1c::query()
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
            return ConsultLaboratoryHba1cResource::collection($laboratory->get());
        }

        return ConsultLaboratoryHba1cResource::collection($laboratory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsultLaboratoryHba1cRequest $request
     * @return JsonResponse
     */
    public function store(ConsultLaboratoryHba1cRequest $request): JsonResponse
    {
        $data = ConsultLaboratoryHba1c::updateOrCreate(['request_id' => $request->safe()->request_id], $request->validated());
        return response()->json(['data' => new ConsultLaboratoryHba1cResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param ConsultLaboratoryHba1c $hba1c
     * @return ConsultLaboratoryHba1cResource
     */
    public function show(ConsultLaboratoryHba1c $hba1c): ConsultLaboratoryHba1cResource
    {
        return new ConsultLaboratoryHba1cResource($hba1c);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConsultLaboratoryHba1cRequest $request
     * @param ConsultLaboratoryHba1c $hba1c
     * @return JsonResponse
     */
    public function update(ConsultLaboratoryHba1cRequest $request, ConsultLaboratoryHba1c $hba1c): JsonResponse
    {
        $hba1c->update($request->validated());
        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConsultLaboratoryHba1c $hba1c
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(ConsultLaboratoryHba1c $hba1c)
    {
        $hba1c->deleteOrFail();
        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
