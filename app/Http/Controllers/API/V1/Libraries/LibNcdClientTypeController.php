<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdClientTypeResource;
use App\Models\V1\Libraries\LibNcdClientType;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 *
 * @subgroup Client Type Answer
 *
 * @subgroupDescription List of Client Type Answers.
 */
class LibNcdClientTypeController extends Controller
{
    /**
     * Display a listing of the Client Type Answer resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdClientTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdClientType
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdClientType::class);

        return LibNcdClientTypeResource::collection($query->get());
    }

    /**
     * Display the specified Client Type Answer Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdClientTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdClientType
     */
    public function show(LibNcdClientType $clientType): LibNcdClientTypeResource
    {
        $query = LibNcdClientType::where('id', $clientType->id);
        $clientType = QueryBuilder::for($query)
            ->first();

        return new LibNcdClientTypeResource($clientType);
    }
}
