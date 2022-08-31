<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\CityResource;
use App\Models\V1\PSGC\City;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $cities = QueryBuilder::for(City::class)->allowedIncludes('barangays', 'subMunicipalities');

        if ($perPage === 'all') {
            return CityResource::collection($cities->get());
        }

        return CityResource::collection($cities->paginate($perPage));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param City  $city
     */
    public function show(Request $request, City $city)
    {
        $query = City::where('id', $city->id);

        $city = QueryBuilder::for($query)
            ->allowedIncludes('barangays', 'subMunicipalities')
            ->first();

        return new CityResource($city);
    }
}
