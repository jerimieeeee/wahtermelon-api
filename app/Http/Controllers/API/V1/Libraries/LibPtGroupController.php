<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPtGroupResource;
use App\Models\V1\Libraries\LibPtGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Patient Group
 *
 * APIs for managing libraries
 * @subgroup Patient Group
 * @subgroupDescription List of Patient Group.
 */
class LibPtGroupController extends Controller
{
    /**
     * Display a listing of the Patient Group resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPtGroupResource
     * @apiResourceModel App\Models\V1\Libraries\LibPtGroup
     * @return ResourceCollection
     */
    public function index()
    {
        return LibPtGroupResource::collection(LibPtGroup::orderBy('id', 'ASC')->get());
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
     * Display the specified Patient Group resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibPtGroupResource
     * @apiResourceModel App\Models\V1\Libraries\LibPtGroup
     * @param LibPtGroup $ptgroup
     * @return LibPtGroupResource
     */
    public function show(LibPtGroup $ptgroup): LibPtGroupResource
    {
        $query = LibPtGroup::where('id', $ptgroup->id);
        $ptgroup = QueryBuilder::for($query)
            ->first();
        return new LibPtGroupResource($ptgroup);
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
