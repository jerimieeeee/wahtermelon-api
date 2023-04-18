<?php

namespace App\Http\Controllers\API\V1\TBDots;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\TBDots\PatientTbRequest;
use App\Http\Resources\API\V1\TBDots\PatientTbResource;
use App\Models\V1\TBDots\PatientTb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient TB
 *
 * APIs for managing tb case
 *
 * @subgroup Patient TB Case.
 *
 * @subgroupDescription List of Patient TB Case.
 */
class PatientTbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort treatment_date. Add hyphen (-) to descend the list: e.g. treatment_date. Example: -treatment_date
     * @queryParam patient_id string Patient to view.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\TBDots\PatientTbResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTb
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientTb::class)
        ->when(isset($request->patient_id), function ($q) use ($request) {
            $q->where('patient_id', $request->patient_id);
        })
        ->with('tbCaseFinding', 'tbCaseHolding', 'treatmentOutcome', 'outcomeReason', 'tbSymptom', 'tbPhysicalExam')
        ->defaultSort('-created_at')
        ->allowedSorts('created_at');

        if ($perPage === 'all') {
            return PatientTbResource::collection($query->get());
        }

        return PatientTbResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\TBDots\PatientTbResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTb
     */
    public function store(PatientTbRequest $request): JsonResponse
    {
        $data = PatientTb::create($request->validated());
        $data->tbCaseFinding()->create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\TBDots\PatientTbResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTb
     */
    public function show(PatientTb $patientTb)
    {
        $query = PatientTb::where('id', $patientTb->id);
        $patientTb = QueryBuilder::for($query)
        ->with('treatmentOutcome', 'outcomeReason', 'tbCaseFinding', 'tbSymptom', 'tbPhysicalExam')
        ->first();

        return new PatientTb($patientTb);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientTbRequest $request, PatientTb $patientTb)
    {
        $patientTb->update($request->validated());

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
