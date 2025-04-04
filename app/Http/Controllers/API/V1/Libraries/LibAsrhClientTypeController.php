<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibAsrhClientTypeResource;
use App\Models\V1\Libraries\LibAsrhClientType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\QueryBuilder;

class LibAsrhClientTypeController extends Controller
{
    /**
     * Display a listing of the ASRH Client Type resource.
     *
     * @queryParam sort string Sort the sequence of ASRH Client Type. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibAsrhClientTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibAsrhClientType
     */
    public function index()
    {
        $sort = request()->get('sort', 'sequence'); // Default to 'sequence' if not provided
        $cacheKey = "lib_asrh_client_type_index_sort_{$sort}";
        $cacheDuration = now()->addDay(); // Cache for a day

        $data = Cache::remember($cacheKey, $cacheDuration, function () {
            return QueryBuilder::for(LibAsrhClientType::class)
                ->defaultSort('sequence')
                ->allowedSorts('sequence')
                ->get();
        });

        return LibAsrhClientTypeResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LibAsrhClientType $asrhClientType)
    {
        $cacheKey = "lib_client_type_show_{$asrhClientType->code}";
        $cacheDuration = now()->addDay(); // Cache for 24 hours

        $asrhClientType = Cache::remember($cacheKey, $cacheDuration, function () use ($asrhClientType) {
            return QueryBuilder::for(LibAsrhClientType::class)
                ->where('code', $asrhClientType->code)
                ->firstOrFail();
        });

        return new LibAsrhClientTypeResource($asrhClientType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
