<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdRiskStratificationResource;
use App\Models\V1\Libraries\LibNcdRiskStratification;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 *
 * @subgroup Risk Stratification
 *
 * @subgroupDescription List of Risk Stratifications.
 */
class LibNcdRiskStratificationController extends Controller
{
    /**
     * Display a listing of the Risk Stratification resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdRiskStratificationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRiskStratification
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdRiskStratification::class);

        return LibNcdRiskStratificationResource::collection($query->get());
    }

    /**
     * Display the specified Risk Stratification Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdRiskStratificationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRiskStratification
     *
     * @param  LibNcdRiskStratificationChart  $riskStratification
     * @return LibNcdRiskStratificationChartResource
     */
    public function show(LibNcdRiskStratification $riskStratification): LibNcdRiskStratificationResource
    {
        $query = LibNcdRiskStratification::where('id', $riskStratification->id);
        $riskStratificationChart = QueryBuilder::for($query)
            ->first();

        return new LibNcdRiskStratificationResource($riskStratificationChart);
    }
}
