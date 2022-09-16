<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\FacilityResource;
use App\Models\V1\PSGC\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries
 *
 * APIs for managing libraries
 * @subgroup Facilities
 * @subgroupDescription MHFR DOH Facilities.
 */
class FacilityController extends Controller
{
    /**
     * Display a listing of the Facility resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @responseFile 200 responses/facilities.get.json
     * @param Request $request
     * @return  ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $barangays = QueryBuilder::for(Facility::class);

        if ($perPage === 'all') {
            return FacilityResource::collection($barangays->get());
        }

        return FacilityResource::collection($barangays->paginate($perPage));
    }

    /**
     * Display the specified Facility resource.
     *
     * @urlParam facility_code string Facility code. Example: DOH000000000000001
     * @responseFile 200 responses/facility.get.json
     * @param Request $request
     * @param Facility $facility
     * @return FacilityResource
     */
    public function show(Request $request, Facility $facility): FacilityResource
    {
        $query = Facility::where('id', $facility->id);

        $facility = QueryBuilder::for($query)
            ->first();
        return new FacilityResource($facility);
    }
}
