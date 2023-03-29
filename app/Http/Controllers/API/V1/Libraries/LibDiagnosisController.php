<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibDiagnosisResource;
use App\Models\V1\Libraries\LibDiagnosis;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Consultation
 *
 * APIs for managing libraries
 *
 * @subgroup Diagnoses
 *
 * @subgroupDescription List of Diagnoses.
 */
class LibDiagnosisController extends Controller
{
    /**
     * Display a listing of the Diagnoses resource.
     *
     * @queryParam filter[search] string Filter by icd10_desc. Example: Dehydration, Severe
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibDiagnosisResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibDiagnosis
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $columns = ['class_name'];
        $diagnosis = QueryBuilder::for(LibDiagnosis::class)
            ->when(isset($request->filter['search']), function ($q) use ($request, $columns) {
                $q->search($request->filter['search'], $columns);
            });

        return LibDiagnosisResource::collection($diagnosis->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Diagnoses resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibDiagnosisResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibDiagnosis
     *
     * @return LibDiagnosisResource
     */
    public function show(LibDiagnosis $class_id, string $id): JsonResource
    {
        return new LibDiagnosisResource($class_id->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
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
