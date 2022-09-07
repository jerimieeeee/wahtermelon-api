<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\FacilityResource;
use App\Models\V1\PSGC\Facility;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $barangays = QueryBuilder::for(Facility::class);

        if ($perPage === 'all') {
            return FacilityResource::collection($barangays->get());
        }

        return FacilityResource::collection($barangays->paginate($perPage));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Facility  $facility
     */
    public function show(Request $request, Facility $facility)
    {
        $query = Facility::where('id', $facility->id);

        $facility = QueryBuilder::for($query)
            ->first();
        return new FacilityResource($facility);
    }
}
