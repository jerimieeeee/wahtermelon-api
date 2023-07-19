<?php

namespace App\Http\Controllers\API\V1\TBDots;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\TBDots\PatientTbCaseHoldingRequest;
use App\Http\Resources\API\V1\TBDots\PatientTbCaseHoldingResource;
use App\Models\V1\TBDots\PatientTbCaseHolding;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient TB
 *
 * APIs for managing tb case holding
 *
 * @subgroup Patient TB Case holdings.
 *
 * @subgroupDescription List of Patient TB Case holdings.
 */
class PatientTbCaseHoldingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort treatment_date. Add hyphen (-) to descend the list: e.g. treatment_date. Example: -treatment_date
     * @queryParam patient_id string Patient to view.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\TBDots\PatientTbCaseHoldingResource
     *
     * @apiResourceModel  App\Models\V1\TBDots\PatientTbCaseHolding
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientTbCaseHolding::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->with('enrollAs', 'treatmentRegimen', 'bacteriologicalStatus', 'anatomicalSite', 'iptType', 'eptbSite')
            ->defaultSort('registration_date')
            ->allowedSort('-registration_date');

        if ($perPage === 'all') {
            return PatientTbCaseHoldingResource::collection($query->get());
        }

        return PatientTbCaseHoldingResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\TBDots\PatientTbCaseHoldingResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbCaseHolding
     */
    public function store(PatientTbCaseHoldingRequest $request): JsonResponse
    {
        $data = PatientTbCaseHolding::updateOrCreate(['patient_tb_id' => $request['patient_tb_id']], $request->validated());

        return response()->json(['data' => $data, 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\TBDots\PatientTbCaseHoldingResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbCaseHolding
     */
    public function show(PatientTbCaseHolding $patientTbCaseHolding)
    {
        $query = PatientTbCaseHolding::where('id', $patientTbCaseHolding->id);
        $patientTbCaseHolding = QueryBuilder::for($query)
            ->first();

        return new PatientTbCaseHolding($patientTbCaseHolding);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientTbCaseHoldingRequest $request, PatientTbCaseHolding $patientTbCaseHolding)
    {
        $patientTbCaseHolding->update($request->validate());

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
