<?php

namespace App\Http\Controllers\API\V1\TBDots;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\TBDots\PatientTbPeRequest;
use App\Http\Resources\API\V1\TBDots\PatientTbPeResource;
use App\Models\V1\TBDots\PatientTbPe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient TB
 *
 * APIs for managing previous tb PE
 *
 * @subgroup Patient TB PE.
 *
 * @subgroupDescription List of Patient TB PE.
 */

class PatientTbPeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string Patient to view.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\TBDots\PatientTbPeResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbPe
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientTbPe::class)
        ->when(isset($request->patient_id), function ($q) use ($request) {
            $q->where('patient_id', $request->patient_id);
        });

        if($perPage === 'all') {
            return PatientTbPeResource::collection($query->get());
        }

        return PatientTbPeResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\TBDots\PatientTbPeResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbPe
     */
    public function store(PatientTbPeRequest $request):JsonResponse
    {
        $data = PatientTbPe::updateOrCreate(['patient_tb_case_findings_id' => $request['patient_tb_case_findings_id']], $request->validated());

        return response()->json(['data' => $data, 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\TBDots\PatientTbPeResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbPe
     */
    public function show(PatientTbPe $patientTbPe)
    {
        $query = PatientTbPe::where('id',  $patientTbPe->id);
        $patientTbPe = QueryBuilder::for($query)
        ->first();

        return new PatientTbPe(($patientTbPe));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientTbPeRequest $request, PatientTbPe $patientTbPe)
    {
        $patientTbPe->update($request->validated());

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
