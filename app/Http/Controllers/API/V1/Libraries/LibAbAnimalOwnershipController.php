<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibAbAnimalOwnershipResource;
use App\Models\V1\Libraries\LibAbAnimalOwnership;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for Animal Bite
 *
 * APIs for managing libraries
 *
 * @subgroup AB Animal Ownership.
 *
 * @subgroupDescription List of AB Animal Ownership.
 */
class LibAbAnimalOwnershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = QueryBuilder::for(LibAbAnimalOwnership::class);

        return LibAbAnimalOwnershipResource::collection($query->get());
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
    public function show(string $id)
    {
        //
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
