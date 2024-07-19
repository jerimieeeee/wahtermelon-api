<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMortalityDeathPlaceResource;
use App\Models\V1\Libraries\LibMortalityDeathPlace;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Mortality Death Place
 *
 * APIs for managing libraries
 *
 * @subgroup Mortality Death Place
 *
 * @subgroupDescription List of Mortality Death Place.
 */
class LibMortalityDeathPlaceController extends Controller
{
    /**
     * Display a listing of the Mortality Death Place resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMortalityDeathPlaceResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMortalityDeathPlace
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMortalityDeathPlace::class)
            ->defaultSort('code')
            ->allowedSorts('code');

        return LibMortalityDeathPlaceResource::collection($query->get());
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
