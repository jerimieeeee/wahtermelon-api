<?php

namespace App\Http\Controllers\API\V1\Laboratory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryHematologyRequest;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryHematologyResource;
use App\Models\V1\Laboratory\ConsultLaboratoryCbc;
use App\Models\V1\Laboratory\ConsultLaboratoryHematology;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Laboratory Management
 *
 * APIs for managing laboratories
 *
 * @subgroup Hematology
 *
 * @subgroupDescription Consult laboratory for Hematology.
 */
class ConsultLaboratoryHematologyController extends Controller
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
     * @apiResourceCollection App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryHematologyResource
     *
     * @apiResourceModel App\Models\V1\Laboratory\ConsultLaboratoryHematology paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = ConsultLaboratoryHematology::query()
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
            return ConsultLaboratoryHematologyResource::collection($laboratory->get());
        }

        return ConsultLaboratoryHematologyResource::collection($laboratory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsultLaboratoryHematologyRequest $request): JsonResponse
    {
        $data = ConsultLaboratoryHematology::updateOrCreate(['request_id' => $request->safe()->request_id], $request->validated());

        return response()->json(['data' => new ConsultLaboratoryHematologyResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConsultLaboratoryHematology $hematology): ConsultLaboratoryHematologyResource
    {
        return new ConsultLaboratoryHematologyResource($hematology);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConsultLaboratoryHematologyRequest $request, ConsultLaboratoryHematology $hematology): JsonResponse
    {
        $hematology->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConsultLaboratoryHematology $hematology)
    {
        $hematology->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
