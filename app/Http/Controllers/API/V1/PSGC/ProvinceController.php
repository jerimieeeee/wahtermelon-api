<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\ProvinceResource;
use App\Models\V1\PSGC\Province;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Address Information
 *
 * APIs for managing libraries
 *
 * @subgroup Provinces
 *
 * @subgroupDescription Philippine Standard Geographic Code (PSGC) Libraries for Provinces.
 */
class ProvinceController extends Controller
{
    /**
     * Display a listing of the Province resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @queryParam include string Relationship to view: e.g. municipalities Example: municipalities
     *
     * @responseFile 200 responses/provinces.get.json
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $provinces = QueryBuilder::for(Province::class)->allowedIncludes('cities', 'municipalities');

        if ($perPage === 'all') {
            return ProvinceResource::collection($provinces->get());
        }

        return ProvinceResource::collection($provinces->paginate($perPage));
    }

    /**
     * Display the specified Province resource.
     *
     * @urlParam province_code string Province code. Example: 012800000
     *
     * @queryParam include string Relationship to view: e.g. municipalities Example: municipalities
     *
     * @responseFile 200 responses/province.get.json
     */
    public function show(Request $request, Province $province): ProvinceResource
    {
        $query = Province::where('id', $province->id);

        $province = QueryBuilder::for($query)
            ->allowedIncludes('cities', 'municipalities')
            ->first();

        return new ProvinceResource($province);
    }
}
