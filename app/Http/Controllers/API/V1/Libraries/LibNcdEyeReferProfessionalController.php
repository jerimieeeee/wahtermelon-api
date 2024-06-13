<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdEyeReferProfessionalResource;
use App\Models\V1\Libraries\LibNcdEyeReferProfessional;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 *
 * @subgroup Eye Refer Professional
 *
 * @subgroupDescription List of Eye Refer Professionals.
 */
class LibNcdEyeReferProfessionalController extends Controller
{
    /**
     * Display a listing of the Location Type resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdEyeReferProfessionalResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdEyeReferProfessional
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdEyeReferProfessional::class);

        return LibNcdEyeReferProfessionalResource::collection($query->get());
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
