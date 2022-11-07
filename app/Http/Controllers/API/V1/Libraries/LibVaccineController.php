<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibVaccineResource;
use App\Models\V1\Libraries\LibVaccine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Libraries for Vaccines
 *
 * APIs for managing libraries
 * @subgroup Vaccines
 * @subgroupDescription List of Vaccines.
 */

class LibVaccineController extends Controller
{
    /**
     * Display a listing of the Vaccine resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibVaccineResource
     * @apiResourceModel App\Models\V1\Libraries\LibVaccine
     * @return ResourceCollection
     */
    public function index()
    {
        return LibVaccineResource::collection(LibVaccine::orderBy('vaccine_id', 'ASC')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Vaccine resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibVaccineResource
     * @apiResourceModel App\Models\V1\Libraries\LibVaccine
     * @param LibVaccine $vaccine_id
     * @return LibVaccineResource
     */
    public function show(LibVaccine $vaccine_id, string $id): JsonResource
    {
        return new LibVaccineResource($vaccine_id->findOrFail($id));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
