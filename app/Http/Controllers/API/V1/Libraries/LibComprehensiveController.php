<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibComprehensiveResource;
use App\Models\V1\Libraries\LibComprehensive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\QueryBuilder;

class LibComprehensiveController extends Controller
{
    /**
     * Display a listing of the Comprehensive HEEADSSSS resource.
     *
     * @queryParam sort string Sort the sequence of Comprehensive HEEADSSSS. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibComprehensiveResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibComprehensive
     */
    public function index()
    {
        $sort = request()->get('sort', 'sequence'); // Default to 'sequence' if not provided
        $cacheKey = "lib_comprehensive_index_sort_{$sort}";
        $cacheDuration = now()->addDay(); // Cache for a day

        $data = Cache::remember($cacheKey, $cacheDuration, function () {
            return QueryBuilder::for(LibComprehensive::class)
                ->with('questions')
                ->defaultSort('sequence')
                ->allowedSorts('sequence')
                ->get();
        });

        return LibComprehensiveResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Comprehensive HEEADSSSS resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibComprehensiveResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibComprehensive
     */
    public function show(LibComprehensive $comprehensive)
    {
        /* $query = LibComprehensive::where('code', $comprehensive->code);
        $comprehensive = QueryBuilder::for($query)
            ->first();

        return new LibComprehensiveResource($comprehensive); */
        $cacheKey = "lib_comprehensive_show_{$comprehensive->code}";
        $cacheDuration = now()->addDay(); // Cache for 24 hours

        $comprehensive = Cache::remember($cacheKey, $cacheDuration, function () use ($comprehensive) {
            return QueryBuilder::for(LibComprehensive::class)
                ->with('questions')
                ->where('code', $comprehensive->code)
                ->firstOrFail();
        });

        return new LibComprehensiveResource($comprehensive);
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
