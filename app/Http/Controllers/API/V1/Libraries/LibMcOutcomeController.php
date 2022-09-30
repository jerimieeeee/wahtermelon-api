<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMcOutcomeResource;
use App\Models\V1\Libraries\LibMcOutcome;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Maternal Care
 *
 * APIs for managing libraries
 * @subgroup Outcome
 * @subgroupDescription List of outcomes.
 */
class LibMcOutcomeController extends Controller
{
    /**
     * Display a listing of the Outcome resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMcOutcomeResource
     * @apiResourceModel App\Models\V1\Libraries\LibMcOutcome
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMcOutcome::class);
        return LibMcOutcomeResource::collection($query->get());
    }

    /**
     * Display the specified Outcome resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMcOutcomeResource
     * @apiResourceModel App\Models\V1\Libraries\LibMcOutcome
     * @param LibMcOutcome $outcome
     * @return LibMcOutcomeResource
     */
    public function show(LibMcOutcome $outcome): LibMcOutcomeResource
    {
        $query = LibMcOutcome::where('code', $outcome->code);
        $outcome = QueryBuilder::for($query)
            ->first();
        return new LibMcOutcomeResource($outcome);
    }
}
