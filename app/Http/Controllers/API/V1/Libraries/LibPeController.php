<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPeResource;
use App\Models\V1\Libraries\LibPe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Libraries for Consultation
 *
 * APIs for managing libraries
 * @subgroup PEs
 * @subgroupDescription List of PEs.
 */

class LibPeController extends Controller
{

    /**
     * Display a listing of the Physical Exams resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPeResource
     * @apiResourceModel App\Models\V1\Libraries\LibPe
     * @return ResourceCollection
     */

    public function index()
    {
        return LibPeResource::collection(LibPe::orderBy('category_id', 'ASC')->get());
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
     * Display the specified Physical Exams resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibPeResource
     * @apiResourceModel App\Models\V1\Libraries\LibPe
     * @param LibPe $pe_id
     * @return LibPeResource
     */
    public function show(LibPe $pe_id, string $id): JsonResource
    {
        return new LibPeResource($pe_id->findOrFail($id));
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
