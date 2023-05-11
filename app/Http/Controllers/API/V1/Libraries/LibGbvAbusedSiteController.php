<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGbvAbusedSiteResource;
use App\Models\V1\Libraries\LibGbvAbusedSite;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for GBV
 *
 * APIs for managing libraries
 *
 * @subgroup GBV Abused sites.
 *
 * @subgroupDescription List of GBV Abused sites.
 */
class LibGbvAbusedSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibGbvAbusedSiteResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibGbvAbusedSite
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGbvAbusedSite::class);

        return LibGbvAbusedSiteResource::collection($query->get());
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
