<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\ProvinceResource;
use App\Models\V1\PSGC\Province;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries
 *
 * APIs for managing libraries
 * @subgroup Provinces
 * @subgroupDescription PSGC Libraries for Provinces.
 */
class ProvinceController extends Controller
{
    /**
     * Display a listing of the Province resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $provinces = QueryBuilder::for(Province::class)->allowedIncludes('cities', 'municipalities');

        if ($perPage === 'all') {
            return ProvinceResource::collection($provinces->get());
        }

        return ProvinceResource::collection($provinces->paginate($perPage));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Province $province
     * @return ProvinceResource
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
