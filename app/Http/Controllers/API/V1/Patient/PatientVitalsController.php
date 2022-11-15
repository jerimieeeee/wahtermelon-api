<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientVitalsRequest;
use App\Http\Resources\API\V1\Patient\PatientVitalsResource;
use App\Models\V1\Patient\PatientVitals;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Patient Vitals Management
 *
 * APIs for managing patient vital signs
 * @subgroup Patient Vital Signs
 * @subgroupDescription Patient vital signs management.
 */
class PatientVitalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $vitals = QueryBuilder::for(PatientVitals::class);

        if ($perPage == 'all') {
            return PatientVitalsResource::collection($vitals->get());
        }

        return PatientVitalsResource::collection($vitals->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PatientVitalsRequest $request
     * @return JsonResponse
     */
    public function store(PatientVitalsRequest $request): JsonResponse
    {
        $data = PatientVitals::updateOrCreate(['patient_id' => $request->patient_id, 'vitals_date' => $request->vitals_date], $request->validatedWithCasts());
        return response()->json(['data' => new PatientVitalsResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
