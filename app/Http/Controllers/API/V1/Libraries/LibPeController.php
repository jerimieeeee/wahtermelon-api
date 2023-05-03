<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPeResource;
use App\Models\V1\Libraries\LibPe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Consultation
 *
 * APIs for managing libraries
 *
 * @subgroup Physical Exams
 *
 * @subgroupDescription List of Physical Exams.
 */
class LibPeController extends Controller
{
    /**
     * Display a listing of the Physical Exams resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibPe
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $query = QueryBuilder::for(LibPe::class);

        return LibPeResource::collection($query->get());

        return LibPeResource::collection($query->paginate()->withQueryString()->orderBy('seq_id', 'ASC'));
    }

    /**
     * Store a newly created resource in storage.
     *
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
     *
     * @apiResourceModel App\Models\V1\Libraries\LibPe
     *
     * @return LibPeResource
     */
    public function show(LibPe $pe_id, string $id): JsonResource
    {
        return new LibPeResource($pe_id->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
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
