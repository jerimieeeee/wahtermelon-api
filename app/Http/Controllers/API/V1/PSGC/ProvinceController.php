<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\ProvinceResource;
use App\Models\V1\PSGC\Province;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
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
     * @param Province  $province
     */
    public function show(Request $request, Province $province)
    {
        $query = Province::where('id', $province->id);

        $province = QueryBuilder::for($query)
            ->allowedIncludes('cities', 'municipalities')
            ->first();

        return new ProvinceResource($province);
    }
}
