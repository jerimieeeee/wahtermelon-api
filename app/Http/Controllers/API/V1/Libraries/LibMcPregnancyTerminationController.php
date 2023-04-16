<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMcPregnancyTerminationResource;
use App\Models\V1\Libraries\LibMcPregnancyTermination;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Maternal Care
 *
 * APIs for managing libraries
 *
 * @subgroup Pregnancy Termination
 *
 * @subgroupDescription List of Pregnancy Terminations.
 */
class LibMcPregnancyTerminationController extends Controller
{
    /**
     * Display a listing of the Pregnancy Termination resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMcPregnancyTerminationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMcPregnancyTermination
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMcPregnancyTermination::class);

        return LibMcPregnancyTerminationResource::collection($query->get());
    }

    /**
     * Display the specified Pregnancy Termination resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMcPregnancyTerminationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMcPregnancyTermination
     */
    public function show(LibMcPregnancyTermination $pregnancyTermination): LibMcPregnancyTerminationResource
    {
        $query = LibMcPregnancyTermination::where('code', $pregnancyTermination->code);
        $pregnancyTermination = QueryBuilder::for($query)
            ->first();

        return new LibMcPregnancyTerminationResource($pregnancyTermination);
    }
}
