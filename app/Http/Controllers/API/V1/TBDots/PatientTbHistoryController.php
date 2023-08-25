<?php

namespace App\Http\Controllers\API\V1\TBDots;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\TBDots\PatientTbHistoryRequest;
use App\Http\Resources\API\V1\TBDots\PatientTbHistoryResource;
use App\Models\V1\TBDots\PatientTbHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient TB
 *
 * APIs for managing previous tb history
 *
 * @subgroup Patient TB History.
 *
 * @subgroupDescription List of Patient TB History.
 */
class PatientTbHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort treatment_date. Add hyphen (-) to descend the list: e.g. treatment_date. Example: -treatment_date
     * @queryParam patient_id string Patient to view.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\TBDots\PatientTbHistoryResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbHistory paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientTbHistory::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->with('outcome')
            ->defaultSort('-treatment_date')
            ->allowedSorts('-treatment_date');

        if ($perPage === 'all') {
            return PatientTbHistoryResource::collection($query->get());
        }

        return PatientTbHistoryResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\TBDots\PatientTbHistoryResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbHistory
     */
    public function store(PatientTbHistoryRequest $request): JsonResponse
    {
        $data = PatientTbHistory::create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\TBDots\PatientTbHistoryResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbHistory
     */
    public function show(PatientTbHistory $patientTbHistory): PatientTbHistoryResource
    {
        $query = PatientTbHistory::where('id', $patientTbHistory->id);
        $patientTbHistory = QueryBuilder::for($query)
            ->with('outcome')
            ->first();

        return new PatientTbHistoryResource($patientTbHistory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientTbHistoryRequest $request, PatientTbHistory $patientTbHistory)
    {
        $patientTbHistory->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientTbHistory $patientTbHistory)
    {
        $patientTbHistory->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
