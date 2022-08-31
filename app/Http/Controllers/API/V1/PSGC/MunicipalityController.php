<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\MunicipalityResource;
use App\Models\V1\PSGC\Municipality;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $municipalities = QueryBuilder::for(Municipality::class)->allowedIncludes('barangays');

        if ($perPage === 'all') {
            return MunicipalityResource::collection($municipalities->get());
        }

        return MunicipalityResource::collection($municipalities->paginate($perPage));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Municipality  $municipality
     */
    public function show(Request $request, Municipality $municipality)
    {
        $query = Municipality::where('id', $municipality->id);

        $municipality = QueryBuilder::for($query)
            ->allowedIncludes('barangays')
            ->first();

        return new MunicipalityResource($municipality);
    }
}
