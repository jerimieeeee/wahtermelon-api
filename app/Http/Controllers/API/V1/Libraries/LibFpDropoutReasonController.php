<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibFpDropoutReasonResource;
use App\Models\V1\Libraries\LibFpDropoutReason;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class LibFpDropoutReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():ResourceCollection
    {
        $query = QueryBuilder::for(LibFpDropoutReason::class)
                    ->orderBy('fhsis_code', 'ASC');


        return LibFpDropoutReasonResource::collection(($query->get()));
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
