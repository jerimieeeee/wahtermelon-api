<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibOccupationCategoryResource;
use App\Models\V1\Libraries\LibOccupationCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Personal Information
 *
 * APIs for managing libraries
 *
 * @subgroup Occupation Categories
 *
 * @subgroupDescription List of occupation categories.
 */
class LibOccupationCategoryController extends Controller
{
    /**
     * Display a listing of the Occupation Category resource.
     *
     * @queryParam sort string Sort the code of Occupation Categories. Add hyphen (-) to descend the list: e.g. -code. Example: code
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibOccupationCategoryResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibOccupationCategory
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibOccupationCategory::class)
            ->defaultSort('code')
            ->allowedSorts('code');

        return LibOccupationCategoryResource::collection($query->get());
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
     * Display the specified Occupation Category resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibOccupationCategoryResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibOccupationCategory
     */
    public function show(LibOccupationCategory $occupationCategory): LibOccupationCategoryResource
    {
        $query = LibOccupationCategory::where('code', $occupationCategory->code);
        $occupationCategory = QueryBuilder::for($query)
            ->first();

        return new LibOccupationCategoryResource($occupationCategory);
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
