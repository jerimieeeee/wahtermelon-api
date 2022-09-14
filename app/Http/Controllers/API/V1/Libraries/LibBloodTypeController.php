<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibBloodTypeResource;
use App\Models\V1\Libraries\LibBloodType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Patient Module
 *
 * APIs for Patient Information
 * @subgroup Blood Type
 * @subgroupDescription Do stuff with servers
 */
class LibBloodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @subgroup Blood Type
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return LibBloodTypeResource::collection(LibBloodType::orderBy('sequence', 'ASC')->get());
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
     * Display the specified resource.
     *
     * @param LibBloodType $bloodType
     * @return JsonResource
     */
    public function show(LibBloodType $bloodType): JsonResource
    {
        $query = LibBloodType::where('code', $bloodType->code);
        $bloodType = QueryBuilder::for($query)
            ->first();
        return new LibBloodTypeResource($bloodType);
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
