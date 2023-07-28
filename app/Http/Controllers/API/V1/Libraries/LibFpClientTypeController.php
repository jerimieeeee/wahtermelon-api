<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibFpClientTypeResource;
use App\Models\V1\Libraries\LibFpClientType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Family Planning
 *
 * APIs for managing libraries
 *
 * @subgroup Client Types
 *
 * @subgroupDescription List of Family Planning Client Types.
 */
class LibFpClientTypeController extends Controller
{
    /**
     * Display a listing of the Family Planning Client Types resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibFpClientTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibFpClientType
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibFpClientType::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibFpClientTypeResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display a listing of the Family Planning Client Types resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibFpClientTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibFpClientType
     */
    public function show(LibFpClientType $clientType)
    {
        $query = LibFpClientType::where('code', $clientType->code);
        $clientType = QueryBuilder::for($query)
            ->first();

        return new LibFpClientTypeResource($clientType);
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
