<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibTbRegGroupResource;
use App\Models\V1\Libraries\LibTbRegGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for TB
 *
 * APIs for managing libraries
 *
 * @subgroup Registration Group.
 *
 * @subgroupDescription List of Registration Groups.
 */
class LibTbRegGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibTbRegGroupResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibTbRegGroup
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibTbRegGroup::class)
            ->defaultSort('sequence');

        return LibTbRegGroupResource::collection($query->get());
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
