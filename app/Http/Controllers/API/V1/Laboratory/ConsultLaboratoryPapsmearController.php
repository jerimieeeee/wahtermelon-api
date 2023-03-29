<?php

namespace App\Http\Controllers\API\V1\Laboratory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryPapsmearRequest;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryPapsmearResource;
use App\Models\V1\Laboratory\ConsultLaboratoryPapsmear;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

/**
 * @authenticated
 *
 * @group Laboratory Management
 *
 * APIs for managing laboratories
 *
 * @subgroup Papsmear
 *
 * @subgroupDescription Consult laboratory for papsmear.
 */
class ConsultLaboratoryPapsmearController extends Controller
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
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryCreatinineResource
     *
     * @apiResourceModel App\Models\V1\Laboratory\ConsultLaboratoryPapsmear paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = ConsultLaboratoryPapsmear::query()
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            })
            ->when(isset($request->consult_id), function ($query) use ($request) {
                return $query->whereConsultId($request->consult_id);
            })
            ->when(isset($request->request_id), function ($query) use ($request) {
                return $query->whereRequestId($request->request_id);
            });
        $laboratory = QueryBuilder::for($query)
            ->with(['user'])
            ->defaultSort('-laboratory_date')
            ->allowedSorts('laboratory_date');

        if ($perPage == 'all') {
            return ConsultLaboratoryPapsmearResource::collection($laboratory->get());
        }

        return ConsultLaboratoryPapsmearResource::collection($laboratory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsultLaboratoryPapsmearRequest $request): JsonResponse
    {
        $data = ConsultLaboratoryPapsmear::updateOrCreate(['request_id' => $request->safe()->request_id], $request->validated());

        return response()->json(['data' => new ConsultLaboratoryPapsmearResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConsultLaboratoryPapsmear $papsmear): ConsultLaboratoryPapsmearResource
    {
        return new ConsultLaboratoryPapsmearResource($papsmear);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConsultLaboratoryPapsmearRequest $request, ConsultLaboratoryPapsmear $papsmear): JsonResponse
    {
        $papsmear->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Throwable
     */
    public function destroy(ConsultLaboratoryPapsmear $papsmear): JsonResponse
    {
        $papsmear->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
