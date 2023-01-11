<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibManagementResource;
use App\Models\V1\Libraries\LibManagement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Management
 *
 * APIs for managing libraries
 * @subgroup Patient Management
 * @subgroupDescription List of Patient Management.
 */
class LibManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibManagementResource
     * @apiResourceModel App\Models\V1\Libraries\LibManagement
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibManagement::class);
        return LibManagementResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryStoolColorResource
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryStoolColor
     * @param LibLaboratoryStoolColor $stoolColor
     * @return LibLaboratoryStoolColorResource
     */
    public function show(LibManagement $management): LibManagementResource
    {
        $query = LibManagement::where('code', $management->code);
        $management = QueryBuilder::for($query)
            ->first();
        return new LibManagementResource($management);
    }
}
