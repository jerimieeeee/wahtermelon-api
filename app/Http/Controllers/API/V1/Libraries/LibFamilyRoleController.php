<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibFamilyRoleResource;
use App\Models\V1\Libraries\LibFamilyRole;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Household
 *
 * APIs for managing libraries
 *
 * @subgroup Family role
 *
 * @subgroupDescription List of family role.
 */
class LibFamilyRoleController extends Controller
{
    /**
     * Display a listing of the Education resource.
     *
     * @queryParam sort string Sort the code of Family role. Add hyphen (-) to descend the list: e.g. -code. Example: code
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibFamilyRoleResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibFamilyRole
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibFamilyRole::class)
            ->defaultSort('code')
            ->allowedSorts('code');

        return LibFamilyRoleResource::collection($query->get());
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
     * Display the specified Family Role resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibFamilyRoleResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibFamilyRole
     */
    public function show(LibFamilyRole $familyRole): LibFamilyRoleResource
    {
        $query = LibFamilyRole::where('code', $familyRole->code);
        $familyRole = QueryBuilder::for($query)
            ->first();

        return new LibFamilyRoleResource($familyRole);
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
