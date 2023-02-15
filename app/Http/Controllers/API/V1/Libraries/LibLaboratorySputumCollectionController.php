<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratorySputumCollectionResource;
use App\Models\V1\Libraries\LibLaboratorySputumCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 * @subgroup Laboratory Sputum Data Collection
 * @subgroupDescription List of laboratory sputum data collection.
 */
class LibLaboratorySputumCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratorySputumCollectionResource
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratorySputumCollection
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratorySputumCollection::class)->orderBy('code');
        return LibLaboratorySputumCollectionResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratorySputumCollectionResource
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratorySputumCollection
     * @param LibLaboratorySputumCollection $collection
     * @return LibLaboratorySputumCollectionResource
     */
    public function show(LibLaboratorySputumCollection $collection): LibLaboratorySputumCollectionResource
    {
        $query = LibLaboratorySputumCollection::where('code', $collection->code);
        $collection = QueryBuilder::for($query)
            ->first();
        return new LibLaboratorySputumCollectionResource($collection);
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
