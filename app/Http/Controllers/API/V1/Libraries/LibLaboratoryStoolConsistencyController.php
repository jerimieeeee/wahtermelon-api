<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryStoolConsistencyResource;
use App\Models\V1\Libraries\LibLaboratoryStoolColor;
use App\Models\V1\Libraries\LibLaboratoryStoolConsistency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 * @subgroup Laboratory Stool Consistency
 * @subgroupDescription List of Stool Consistency.
 */
class LibLaboratoryStoolConsistencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryStoolConsistencyResource
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryStoolConsistency
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryStoolConsistency::class);
        return LibLaboratoryStoolConsistencyResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryStoolConsistencyResource
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryStoolConsistency
     * @param LibLaboratoryStoolConsistency $stoolConsistency
     * @return LibLaboratoryStoolConsistencyResource
     */
    public function show(LibLaboratoryStoolConsistency $stoolConsistency): LibLaboratoryStoolConsistencyResource
    {
        $query = LibLaboratoryStoolColor::where('code', $stoolConsistency->code);
        $stoolConsistency = QueryBuilder::for($query)
            ->first();
        return new LibLaboratoryStoolConsistencyResource($stoolConsistency);
    }
}
