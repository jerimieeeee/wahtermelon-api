<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdLocationResource;
use App\Models\V1\Libraries\LibNcdLocation;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 *
 * @subgroup Location
 *
 * @subgroupDescription List of Locations.
 */
class LibNcdLocationController extends Controller
{
    /**
     * Display a listing of the Location Type resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdLocationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdLocation
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdLocation::class);

        return LibNcdLocationResource::collection($query->get());
    }

    /**
     * Display the specified Location Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdLocationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdLocation
     *
     * @param  LibNcdLocation  $clientType
     */
    public function show(LibNcdLocation $location): LibNcdLocationResource
    {
        $query = LibNcdLocation::where('id', $location->id);
        $location = QueryBuilder::for($query)
            ->first();

        return new LibNcdLocationResource($location);
    }
}
