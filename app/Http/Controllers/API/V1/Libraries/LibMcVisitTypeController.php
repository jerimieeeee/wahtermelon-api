<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMcVisitTypeResource;
use App\Models\V1\Libraries\LibMcVisitType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Maternal Care
 *
 * APIs for managing libraries
 * @subgroup Visit Type
 * @subgroupDescription List of visit types.
 */
class LibMcVisitTypeController extends Controller
{
    /**
     * Display a listing of the Visit Type resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMcVisitTypeResource
     * @apiResourceModel App\Models\V1\Libraries\LibMcVisitType
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMcVisitType::class);
        return LibMcVisitTypeResource::collection($query->get());
    }

    /**
     * Display the specified Attendant resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMcVisitTypeResource
     * @apiResourceModel App\Models\V1\Libraries\LibMcVisitType
     * @param LibMcVisitType $visitType
     * @return LibMcVisitTypeResource
     */
    public function show(LibMcVisitType $visitType)
    {
        $query = LibMcVisitType::where('code', $visitType->code);
        $visitType = QueryBuilder::for($query)
            ->first();
        return new LibMcVisitTypeResource($visitType);
    }
}
