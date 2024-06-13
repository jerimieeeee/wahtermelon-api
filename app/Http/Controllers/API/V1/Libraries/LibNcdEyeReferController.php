<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdEyeReferResource;
use App\Models\V1\Libraries\LibNcdEyeRefer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 *
 * @subgroup Eye Refer
 *
 * @subgroupDescription List of Eye Refers.
 */
class LibNcdEyeReferController extends Controller
{
    /**
     * Display a listing of the Location Type resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdEyeReferResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdEyeRefer
     */
    public function index():ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdEyeRefer::class);

        return LibNcdEyeReferResource::collection($query->get());
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
