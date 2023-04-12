<?php

namespace App\Http\Controllers\API\V1\TBDots;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\TBDots\PatientTbHistoryRequest;
use App\Http\Requests\API\V1\TBDots\PatientTbSymptomRequest;
use App\Http\Resources\API\V1\TBDots\PatientTbSymptomResource;
use App\Models\V1\TBDots\PatientTbSymptom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient TB
 *
 * APIs for managing tb symptoms
 *
 * @subgroup Patient TB symptoms.
 *
 * @subgroupDescription List of Patient TB symptoms.
 */
class PatientTbSymptomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string Patient to view.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\TBDots\PatientTbSymptomResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbSymptom
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientTbSymptom::class)
        ->when(isset($request->patient_id), function ($q) use ($request) {
            $q->where('patient_id', $request->patient_id);
        });

        if($perPage === 'all') {
            return PatientTbSymptomResource::collection($query->get());
        }

        return PatientTbSymptomResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResouceAddition status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\TBDots\PatientTbSymptomResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbSymptom
     */
    public function store(PatientTbSymptomRequest $request):JsonResponse
    {
        $data = PatientTbSymptom::updateOrCreate(['patient_tb_id' => $request['patient_tb_id']], $request->validated());

        return response()->json(['data' => $data, 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResouce App\Http\Resources\API\V1\TBDots\PatientTbSymptomResource
     *
     * @apiResourceModel App\Models\V1\TBDots\PatientTbSymptom
     */
    public function show(PatientTbSymptom $patientTbSymptom)
    {
        $query = PatientTbSymptom::where('id', $patientTbSymptom->id);
        $patientTbSymptom = QueryBuilder::for($query)
        ->first();

        return new PatientTbSymptom($patientTbSymptom);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientTbSymptomRequest $request, PatientTbSymptom $patientTbSymptom)
    {
        $patientTbSymptom->update($request->validated());

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
