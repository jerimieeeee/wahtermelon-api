<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibEclaimsDocTypeResource;
use App\Models\V1\Libraries\LibEclaimsDocType;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LibEclaimsDocTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = QueryBuilder::for(LibEclaimsDocType::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibEclaimsDocTypeResource::collection($query->get());
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
