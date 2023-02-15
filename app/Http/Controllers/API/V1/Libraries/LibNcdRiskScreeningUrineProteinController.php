<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdRiskScreeningUrineProteinResource;
use App\Models\V1\Libraries\LibNcdRiskScreeningUrineProtein as LibrariesLibNcdRiskScreeningUrineProtein;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 * @subgroup Risk Screening Urine Protein
 * @subgroupDescription List of Risk Screening Urine Protein.
 */
class LibNcdRiskScreeningUrineProteinController extends Controller
{
    /**
     * Display a listing of the Risk Screening Urine Ketones resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdRiskScreeningUrineProteinResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRiskScreeningUrineProtein
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibrariesLibNcdRiskScreeningUrineProtein::class);
        return LibNcdRiskScreeningUrineProteinResource::collection($query->get());
    }
        /**
     * Display the specified Risk Screening Urine Protein Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdRiskScreeningUrineProteinResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRiskScreeningUrineProtein
     * @param LibrariesLibNcdRiskScreeningUrineProtein $riskScreeningUrineProtein
     * @return LibNcdRiskScreeningUrineProteinResource
     */
    public function show(LibrariesLibNcdRiskScreeningUrineProtein $riskScreeningUrineProtein): LibNcdRiskScreeningUrineProteinResource
    {
        $query = LibrariesLibNcdRiskScreeningUrineProtein::where('id', $riskScreeningUrineProtein->id);
        $riskScreeningUrineProtein = QueryBuilder::for($query)
            ->first();
        return new LibNcdRiskScreeningUrineProteinResource($riskScreeningUrineProtein);
    }
}
