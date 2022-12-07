<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\SubMunicipalityResource;
use App\Models\V1\PSGC\SubMunicipality;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class SubMunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $subMunicipalities = QueryBuilder::for(SubMunicipality::class)->allowedIncludes('barangays');

        if ($perPage === 'all') {
            return SubMunicipalityResource::collection($subMunicipalities->get());
        }

        return SubMunicipalityResource::collection($subMunicipalities->paginate($perPage));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param SubMunicipality  $subMunicipality
     */
    public function show(Request $request, SubMunicipality $subMunicipality)
    {
        $query = SubMunicipality::where('id', $subMunicipality->id);

        $subMunicipality = QueryBuilder::for($query)
            ->allowedIncludes('barangays')
            ->first();

        return new SubMunicipalityResource($subMunicipality);
    }
}
