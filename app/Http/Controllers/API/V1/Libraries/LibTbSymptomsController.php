<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibTbSymptomsResource;
use App\Models\V1\Libraries\LibTbSymptoms;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for TB
 *
 * APIs for managing libraries
 *
 * @subgroup TB Symptoms.
 *
 * @subgroupDescription List of TB Symptoms.
 */
class LibTbSymptomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibTbSymptomsResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibTbSymptoms
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibTbSymptoms::class);

        return LibTbSymptomsResource::collection($query->get());
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
