<?php

namespace App\Http\Controllers\API\V1\Laboratory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryCervicalCancerRequest;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryCervicalCancerScreeningRequest;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryCervicalCancerResource;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryCervicalCancerScreeningResource;
use App\Models\V1\Laboratory\ConsultLaboratoryCervicalCancer;
use App\Models\V1\Laboratory\ConsultLaboratoryCervicalCancerScreening;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @authenticated
 *
 * @group Laboratory Management
 *
 * APIs for managing laboratories
 *
 * @subgroup Cervical Cancer Screening Test
 *
 * @subgroupDescription Consult laboratory for Cervical Cancer Screening Test.
 */
class ConsultLaboratoryCervicalCancerController extends Controller
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
     * @apiResourceCollection App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryCervicalCancerResource
     *
     * @apiResourceModel App\Models\V1\Laboratory\ConsultLaboratoryCervicalCancer paginate=15
     *
     * @return ResourceCollection
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = ConsultLaboratoryCervicalCancer::query()
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
            return ConsultLaboratoryCervicalCancerResource::collection($laboratory->get());
        }

        return ConsultLaboratoryCervicalCancerResource::collection($laboratory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsultLaboratoryCervicalCancerRequest $request)
    {
        $data = ConsultLaboratoryCervicalCancer::updateOrCreate(['request_id' => $request->safe()->request_id], $request->validated());

        return response()->json(['data' => new ConsultLaboratoryCervicalCancerResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConsultLaboratoryCervicalCancer $cancerScreening): ConsultLaboratoryCervicalCancerResource
    {
        return new ConsultLaboratoryCervicalCancerResource($cancerScreening);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConsultLaboratoryCervicalCancerRequest $request, ConsultLaboratoryCervicalCancer $cancerScreening)
    {
        $cancerScreening->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConsultLaboratoryCervicalCancer $cancerScreening)
    {
        $cancerScreening->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
