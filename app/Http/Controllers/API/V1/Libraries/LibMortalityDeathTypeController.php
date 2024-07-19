<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMortalityDeathTypeResource;
use App\Models\V1\Libraries\LibMortalityDeathType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Mortality Death Type
 *
 * APIs for managing libraries
 *
 * @subgroup Mortality Death Type
 *
 * @subgroupDescription List of Mortality Death Type.
 */
class LibMortalityDeathTypeController extends Controller
{
    /**
     * Display a listing of the Mortality Death Type resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMortalityDeathTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMortalityDeathType
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMortalityDeathType::class)
            ->defaultSort('code')
            ->allowedSorts('code');

        return LibMortalityDeathTypeResource::collection($query->get());
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
    public function show(string $id)
    {
        //
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
