<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMortalityCauseResource;
use App\Http\Resources\API\V1\Libraries\LibMortalityDeathPlaceResource;
use App\Models\V1\Libraries\LibMortalityCause;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Mortality Cause
 *
 * APIs for managing libraries
 *
 * @subgroup Mortality Cause
 *
 * @subgroupDescription List of Mortality Cause.
 */
class LibMortalityCauseController extends Controller
{
    /**
     * Display a listing of the Mortality Cause resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMortalityCauseResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMortalityCause
     */
    public function index():ResourceCollection
    {
        $query = QueryBuilder::for(LibMortalityCause::class)
            ->defaultSort('code')
            ->allowedSorts('code');

        return LibMortalityCauseResource::collection($query->get());
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
