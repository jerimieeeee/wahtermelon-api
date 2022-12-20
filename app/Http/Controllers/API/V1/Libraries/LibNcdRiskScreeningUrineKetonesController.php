<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdRiskScreeningUrineKetonesResource;
use App\Models\V1\Libraries\LibNcdRiskScreeningUrineKetones;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 * @subgroup Risk Screening Ketones
 * @subgroupDescription List of Risk Screening Ketones.
 */
class LibNcdRiskScreeningUrineKetonesController extends Controller
{
    /**
     * Display a listing of the Risk Screening Urine Ketones resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdRiskScreeningUrineKetonesResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRiskScreeningUrineKetones
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdRiskScreeningUrineKetones::class);
        return LibNcdRiskScreeningUrineKetonesResource::collection($query->get());
    }
    /**
     * Display the specified Risk Screening Urine Ketones Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdRiskScreeningUrineKetonesResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRiskScreeningUrineKetones
     * @param LibNcdRiskScreeningUrineKetones $riskScreeningUrineKetones
     * @return LibNcdRiskScreeningUrineKetonesResource
     */
    public function show(LibNcdRiskScreeningUrineKetones $riskScreeningUrineKetones): LibNcdRiskScreeningUrineKetonesResource
    {
        $query = LibNcdRiskScreeningUrineKetones::where('id', $riskScreeningUrineKetones->id);
        $riskScreeningUrineKetones = QueryBuilder::for($query)
            ->first();
        return new LibNcdRiskScreeningUrineKetonesResource($riskScreeningUrineKetones);
    }
}
