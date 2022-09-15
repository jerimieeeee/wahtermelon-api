<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\MunicipalityResource;
use App\Models\V1\PSGC\Municipality;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries
 *
 * APIs for managing libraries
 * @subgroup Municipalities
 * @subgroupDescription Philippine Standard Geographic Code (PSGC) Libraries for Municipalities.
 */
class MunicipalityController extends Controller
{
    /**
     * Display a listing of the Municipality resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @queryParam include string Relationship to view: e.g. barangays Example: barangays
     * @responseFile 200 responses/municipalities.get.json
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $municipalities = QueryBuilder::for(Municipality::class)->allowedIncludes('barangays');

        if ($perPage === 'all') {
            return MunicipalityResource::collection($municipalities->get());
        }

        return MunicipalityResource::collection($municipalities->paginate($perPage));
    }

    /**
     * Display the specified Municipality resource.
     *
     * @urlParam municipality_code string Province code. Example: 012801000
     * @queryParam include string Relationship to view: e.g. barangays Example: barangays
     * @responseFile 200 responses/municipality.get.json
     * @param Request $request
     * @param Municipality $municipality
     * @return MunicipalityResource
     */
    public function show(Request $request, Municipality $municipality): MunicipalityResource
    {
        $query = Municipality::where('id', $municipality->id);

        $municipality = QueryBuilder::for($query)
            ->allowedIncludes('barangays')
            ->first();

        return new MunicipalityResource($municipality);
    }
}
