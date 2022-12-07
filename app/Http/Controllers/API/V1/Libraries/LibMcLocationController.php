<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMcLocationResource;
use App\Models\V1\Libraries\LibMcLocation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Maternal Care
 *
 * APIs for managing libraries
 * @subgroup Location
 * @subgroupDescription List of locations.
 */
class LibMcLocationController extends Controller
{
    /**
     * Display a listing of the Location resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMcLocationResource
     * @apiResourceModel App\Models\V1\Libraries\LibMcLocation
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMcLocation::class);
        return LibMcLocationResource::collection($query->get());
    }

    /**
     * Display the specified Location resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMcLocationResource
     * @apiResourceModel App\Models\V1\Libraries\LibMcLocation
     * @param LibMcLocation $location
     * @return LibMcLocationResource
     */
    public function show(LibMcLocation $location): LibMcLocationResource
    {
        $query = LibMcLocation::where('code', $location->code);
        $location = QueryBuilder::for($query)
            ->first();
        return new LibMcLocationResource($location);
    }
}
