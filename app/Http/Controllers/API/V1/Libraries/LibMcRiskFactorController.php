<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMcRiskFactorResource;
use App\Models\V1\Libraries\LibMcRiskFactor;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Maternal Care
 *
 * APIs for managing libraries
 *
 * @subgroup Risk Factor
 *
 * @subgroupDescription List of Risk Factors.
 */
class LibMcRiskFactorController extends Controller
{
    /**
     * Display a listing of the Risk Factor resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMcRiskFactorResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMcRiskFactor
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMcRiskFactor::class);

        return LibMcRiskFactorResource::collection($query->get());
    }

    /**
     * Display the specified Risk Factor resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMcRiskFactorResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMcRiskFactor
     */
    public function show(LibMcRiskFactor $riskFactor): LibMcRiskFactorResource
    {
        $query = LibMcRiskFactor::where('id', $riskFactor->id);
        $riskFactor = QueryBuilder::for($query)
            ->first();

        return new LibMcRiskFactorResource($riskFactor);
    }
}
