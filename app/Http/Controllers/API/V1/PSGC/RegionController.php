<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\RegionResource;
use App\Models\V1\PSGC\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Address Information
 *
 * APIs for managing libraries
 * @subgroup Regions
 * @subgroupDescription Philippine Standard Geographic Code (PSGC) Libraries for Regions.
 */
class RegionController extends Controller
{
    /**
     * Display a listing of the Region resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @queryParam include string Relationship to view: e.g. provinces Example: provinces
     * @responseFile 200 responses/regions.get.json
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $regions = QueryBuilder::for(Region::class)->allowedIncludes('provinces', 'districts');

        if ($perPage === 'all') {
            return RegionResource::collection($regions->get());
        }

        return RegionResource::collection($regions->paginate($perPage));
    }

    /**
     * Display the specified Region resource.
     *
     * @urlParam region_code string Region code. Example: 010000000
     * @queryParam include string Relationship to view: e.g. provinces Example: provinces
     * @responseFile 200 responses/region.get.json
     * @param Request $request
     * @param Region $region
     * @return RegionResource
     */
    public function show(Request $request, Region $region): RegionResource
    {
        $query = Region::where('id', $region->id);

        $region = QueryBuilder::for($query)
            ->allowedIncludes('provinces', 'districts')
            ->first();

        return new RegionResource($region);
    }
}
