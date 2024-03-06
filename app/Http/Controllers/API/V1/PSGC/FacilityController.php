<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\FacilityResource;
use App\Models\V1\PSGC\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Address Information
 *
 * APIs for managing libraries
 *
 * @subgroup Facilities
 *
 * @subgroupDescription MHFR DOH Facilities.
 */
class FacilityController extends Controller
{
    /**
     * Display a listing of the Facility resource.
     *
     * @queryParam filter[code] string Filter by facility code. Example: DOH000000000004172
     * @queryParam filter[facility_name] string Filter by facility name. Example: ADAMS MUNICIPAL HEALTH OFFICE
     * @queryParam filter[region_code] string Filter by region. Example: 010000000
     * @queryParam filter[province_code] string Filter by province. Example: 012800000
     * @queryParam filter[municipality_code] string Filter by municipality. Example: 012801000
     * @queryParam filter[barangay_code] string Filter by barangay. Example: 012801001
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @responseFile 200 responses/facilities.get.json
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $facilities = QueryBuilder::for(Facility::class)
            ->with('barangay', 'municipality', 'province', 'region')
            ->allowedFilters(['barangay_code', 'municipality_code', 'province_code', 'region_code', 'code', 'facility_name'])
            ->defaultSort('facility_name')
            ->allowedSorts('facility_name');

        if ($perPage === 'all') {
            return FacilityResource::collection($facilities->get());
        }

        return FacilityResource::collection($facilities->paginate($perPage)->withQueryString());
    }

    /**
     * Display the specified Facility resource.
     *
     * @urlParam facility_code string Facility code. Example: DOH000000000000001
     *
     * @responseFile 200 responses/facility.get.json
     */
    public function show(Request $request, Facility $facility): FacilityResource
    {
        $query = Facility::where('id', $facility->id);

        $facility = QueryBuilder::for($query)
            ->first();

        return new FacilityResource($facility);
    }
}
