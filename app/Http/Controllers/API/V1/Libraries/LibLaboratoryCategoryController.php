<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryCategoryResource;
use App\Models\V1\Libraries\LibLaboratoryCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Categories
 *
 * @subgroupDescription List of Laboratory Categories.
 */
class LibLaboratoryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam filter[lab_code] string Filter by lab_code. Example: CBC
     * @queryParam include string Relationship to view: e.g. laboratory Example: laboratory
     * @queryParam sort string Sort lab_code, sequence_id. Add hyphen (-) to descend the list: e.g. lab_code,sequence_id. Example: lab_code,sequence_id
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryCategoryResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryCategory
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryCategory::class)
            ->allowedFilters(['lab_code'])
            ->allowedIncludes('laboratory')
            ->defaultSort('lab_code', 'sequence_id')
            ->allowedSorts(['lab_code', 'sequence_id'])
            ->whereFieldActive(1)
            ->whereRelation('laboratory', 'lab_active', true);

        return LibLaboratoryCategoryResource::collection($query->get());
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
