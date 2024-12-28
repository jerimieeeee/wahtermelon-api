<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibComprehensiveResource;
use App\Models\V1\Libraries\LibComprehensive;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LibComprehensiveController extends Controller
{
    /**
     * Display a listing of the PWD Type resource.
     *
     * @queryParam sort string Sort the sequence of Occupations. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibComprehensiveResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibComprehensive
     */
    public function index()
    {
        $query = QueryBuilder::for(LibComprehensive::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibComprehensiveResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified PWD Type resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibCOmprehensiveResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibComprehensive
     */
    public function show(LibComprehensive $comprehensive)
    {
        $query = LibComprehensive::where('code', $comprehensive->code);
        $comprehensive = QueryBuilder::for($query)
            ->first();

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
