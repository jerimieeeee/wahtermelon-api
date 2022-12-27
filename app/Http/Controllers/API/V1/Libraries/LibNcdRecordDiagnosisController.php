<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdRecordDiagnosisResource;
use App\Models\V1\Libraries\LibNcdRecordDiagnosis;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 * @subgroup Patient NCD Record Diagnosis
 * @subgroupDescription List of Patient NCD Record Diagnosis.
 */
class LibNcdRecordDiagnosisController extends Controller
{
    /**
     * Display a listing of the NCD Record Diagnosis resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdRecordDiagnosisResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRecordDiagnosis
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdRecordDiagnosis::class);
        return LibNcdRecordDiagnosisResource::collection($query->get());
    }
    /**
     * Display the specified NCD Record Diagnosis Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdRecordDiagnosisResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRecordDiagnosis
     * @param LibNcdRecordDiagnosis $diagnosis
     * @return LibNcdRecordDiagnosisResource
     */
    public function show(LibNcdRecordDiagnosis $diagnosis): LibNcdRecordDiagnosisResource
    {
        $query = LibNcdRecordDiagnosis::where('id', $diagnosis->id);
        $diagnosis = QueryBuilder::for($query)
            ->first();
        return new LibNcdRecordDiagnosisResource($diagnosis);
    }
}
