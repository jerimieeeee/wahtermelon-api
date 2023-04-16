<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdRecordTargetOrganResource;
use App\Models\V1\Libraries\LibNcdRecordTargetOrgan;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 *
 * @subgroup Patient NCD Record Target Organ
 *
 * @subgroupDescription List of Patient NCD Record Target Organ.
 */
class LibNcdRecordTargetOrganController extends Controller
{
    /**
     * Display a listing of the NCD Record Diagnosis resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdRecordTargetOrganResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRecordTargetOrgan
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdRecordTargetOrgan::class);

        return LibNcdRecordTargetOrganResource::collection($query->get());
    }

    /**
     * Display the specified NCD Record Target Orga Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdRecordTargetOrganResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRecordTargetOrgan
     */
    public function show(LibNcdRecordTargetOrgan $targetOrgan): LibNcdRecordTargetOrganResource
    {
        $query = LibNcdRecordTargetOrgan::where('id', $targetOrgan->id);
        $targetOrgan = QueryBuilder::for($query)
            ->first();

        return new LibNcdRecordTargetOrganResource($targetOrgan);
    }
}
