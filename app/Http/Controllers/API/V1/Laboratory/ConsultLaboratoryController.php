<?php

namespace App\Http\Controllers\API\V1\Laboratory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Laboratory\ConsultLaboratoryRequest;
use App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryResource;
use App\Models\V1\Laboratory\ConsultLaboratory;
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
 * @subgroup Consult Laboratory
 *
 * @subgroupDescription Consult laboratory management.
 */
class ConsultLaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam include string Relationship to view: e.g. laboratory,recommendation,requestStatus Example: laboratory
     * @queryParam sort string Sort request_date. Add hyphen (-) to descend the list: e.g. prescription_date. Example: -request_date
     * @queryParam patient_id string Patient to view.
     * @queryParam consult_id string Consult to view.
     * @queryParam recommendation_code string Recommendation to view. Example: Y
     * @queryParam request_status_code string Request status to view. Example: RQ
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Laboratory\ConsultLaboratoryResource
     *
     * @apiResourceModel App\Models\V1\Laboratory\ConsultLaboratory paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = ConsultLaboratory::query()
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            })
            ->when(isset($request->consult_id), function ($query) use ($request) {
                return $query->whereConsultId($request->consult_id);
            })
            ->when(isset($request->recommendation_code), function ($query) use ($request) {
                return $query->whereRecommendationCode($request->recommendation_code);
            })
            ->when(isset($request->request_status_code), function ($query) use ($request) {
                return $query->whereRequestStatusCode($request->request_status_code);
            });
        $laboratory = QueryBuilder::for($query)
            ->with('cbc',
                'creatinine',
                'chestXray',
                'ecg',
                'fbs',
                'rbs',
                'hba1c',
                'papsmear',
                'ppd',
                'sputum',
                'fecalysis',
                'lipiProfile',
                'urinalysis',
                'oralGlucose',
                'fecalOccult',
                'gramStain',
                'microscopy',
                'ultrasound',
                'geneXpert',
                'dengueRdt',
                'serology',
                'biopsy',
                'malariaRdt',
                'skinSlit',
                'wetSmear',
                'bloodchem',
                'potassium',
                'hematology',
                'syphilis',
                'cervical')
            ->allowedIncludes('laboratory', 'recommendation', 'requestStatus')
            ->defaultSort('-request_date')
            ->allowedSorts('request_date');

        if ($perPage == 'all') {
            return ConsultLaboratoryResource::collection($laboratory->get());
        }

        return ConsultLaboratoryResource::collection($laboratory->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsultLaboratoryRequest $request): JsonResponse
    {
        $data = ConsultLaboratory::create($request->validated());

        return response()->json(['data' => new ConsultLaboratoryResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConsultLaboratory $laboratory): ConsultLaboratoryResource
    {
        return new ConsultLaboratoryResource($laboratory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConsultLaboratoryRequest $request, ConsultLaboratory $laboratory): JsonResponse
    {
        $laboratory->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Throwable
     */
    public function destroy(ConsultLaboratory $laboratory): JsonResponse
    {
        $laboratory->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
