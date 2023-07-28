<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibFpHistoryResource;
use App\Models\V1\Libraries\LibFpHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Family Planning
 *
 * APIs for managing libraries
 *
 * @subgroup Histories
 *
 * @subgroupDescription List of Family Planning Histories.
 */
class LibFpHistoryController extends Controller
{
    /**
     * Display a listing of the Family Planning Histories resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibFpHistoryResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibFpHistory
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibFpHistory::class)
            ->defaultSort('code')
            ->allowedSorts('code');

        return LibFpHistoryResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Family Planning History resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibFpHistoryResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibFpHistory
     */
    public function show(LibFpHistory $fpHistory): LibFpHistoryResource
    {
        $query = LibFpHistory::where('code', $fpHistory->code);
        $fpHistory = QueryBuilder::for($query)
            ->first();

        return new LibFpHistoryResource($fpHistory);
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
