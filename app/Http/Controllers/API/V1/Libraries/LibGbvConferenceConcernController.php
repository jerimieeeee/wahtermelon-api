<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGbvConferenceConcernResource;
use App\Models\V1\Libraries\LibGbvConferenceConcern;
use Database\Seeders\LibGbvConferenceConcernSeeder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
/**
 * @group libraries for GBV
 *
 * APIs for managing libraries
 *
 * @subgroup GBV Conference concerns.
 *
 * @subgroupDescription List of GBV Conference concerns.
 */
class LibGbvConferenceConcernController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection
     *
     * @apiResourceModel
     *
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGbvConferenceConcern::class);

        return LibGbvConferenceConcernResource::collection($query->get());
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
