<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdRiskStratificationChartResource;
use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 * @subgroup Risk Stratification Chart
 * @subgroupDescription List of Risk Stratification Charts.
 */
class LibNcdRiskStratificationChartController extends Controller
{
    /**
     * Display a listing of the Risk Stratification Chart resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdRiskStratificationChartResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRiskStratificationChart
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdRiskStratificationChart::class);
        return LibNcdRiskStratificationChartResource::collection($query->get());
    }
    /**
     * Display the specified Risk Stratification Chart Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdRiskStratificationChartResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRiskStratificationChart
     * @param LibNcdRiskStratificationChart $riskStratificationChart
     * @return LibNcdRiskStratificationChartResource
     */
    public function show(LibNcdRiskStratificationChart $riskStratificationChart): LibNcdRiskStratificationChartResource
    {
        $query = LibNcdRiskStratificationChart::where('id', $riskStratificationChart->id);
        $riskStratificationChart = QueryBuilder::for($query)
            ->first();
        return new LibNcdRiskStratificationChartResource($riskStratificationChart);
    }
}
