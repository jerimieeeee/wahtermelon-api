<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratorySyphilisTestMethodResource;
use App\Models\V1\Libraries\LibLaboratorySyphilisTestMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Syphilis Test Method
 *
 * @subgroupDescription List of laboratory Syphilis Test Method.
 */
class LibLaboratorySyphilisTestMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratorySyphilisTestMethodResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratorySyphilisTestMethod
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratorySyphilisTestMethod::class);

        return LibLaboratorySyphilisTestMethodResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LibLaboratorySyphilisTestMethod $syphilisTestMethod): LibLaboratorySyphilisTestMethodResource
    {
        $query = LibLaboratorySyphilisTestMethod::where('code', $syphilisTestMethod->code);
        $syphilisTestMethod = QueryBuilder::for($query)
            ->first();

        return new LibLaboratorySyphilisTestMethodResource($syphilisTestMethod);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
