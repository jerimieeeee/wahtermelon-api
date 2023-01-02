<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryResource;
use App\Models\V1\Libraries\LibLaboratory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 * @subgroup Laboratory
 * @subgroupDescription List of laboratories.
 */
class LibLaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryResource
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratory
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratory::class)
                ->with('category')
                ->whereLabActive(1);
        return LibLaboratoryResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryResource
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratory
     * @param LibLaboratory $laboratory
     * @return LibLaboratoryResource
     */
    public function show(LibLaboratory $laboratory): LibLaboratoryResource
    {
        $query = LibLaboratory::where('code', $laboratory->code);
        $laboratory = QueryBuilder::for($query)
            ->with('category')
            ->first();
        return new LibLaboratoryResource($laboratory);
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
