<?php

namespace App\Http\Controllers\API\V1\TBDots;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\TBDots\PatientTbCaseFindingRequest;
use App\Http\Resources\API\V1\TBDots\PatientTbCaseFindingResource;
use App\Models\V1\TBDots\PatientTbCaseFinding;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient TB
 *
 * APIs for managing tb case findings
 *
 * @subgroup Patient TB Casefindings.
 *
 * @subgroupDescription List of Patient TB Casefindings.
 */

class PatientTbCaseFindingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort treatment_date. Add hyphen (-) to descend the list: e.g. treatment_date. Example: -treatment_date
     * @queryParam patient_id string Patient to view.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\TBDots\PatientTbCaseFindingResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbCaseFinding
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientTbCaseFinding::class)
        ->when(isset($request->patient_id), function ($q) use ($request) {
            $q->where('patient_id', $request->patient_id);
        })
        ->with('source', 'reg_group', 'previous_tb_treatment', 'symptom', 'physical_exam')
        ->defaultSort('consult_date')
        ->allowedSorts('-consult_date');

        if($perPage === 'all') {
            return PatientTbCaseFindingResource::collection($query->get());
        }

        return PatientTbCaseFindingResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\TBDots\PatientTbCaseFindingResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbCaseFinding
     */
    public function store(PatientTbCaseFindingRequest $request):JsonResponse
    {
        $data = PatientTbCaseFinding::create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\TBDots\PatientTbCaseFindingResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbCaseFinding
     */
    public function show(PatientTbCaseFinding $patientTbCaseFinding)
    {
        $query = PatientTbCaseFinding::where('id', $patientTbCaseFinding->id);
        $patientTbCaseFinding = QueryBuilder::for($query)
        ->with('source', 'reg_group', 'previous_tb_treatment')
        ->first();

        return new PatientTbCaseFinding($patientTbCaseFinding);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientTbCaseFindingRequest $request, PatientTbCaseFinding $patientTbCaseFinding)
    {
        $patientTbCaseFinding->update($request->validated());

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
