<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibOccupationResource;
use App\Models\V1\Libraries\LibOccupation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

class LibOccupationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $query = QueryBuilder::for(LibOccupation::class)
            ->defaultSort('occupation_desc')
            ->allowedSorts('occupation_desc');
        return LibOccupationResource::collection($query->get());
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
     * @param LibOccupation $occupation
     * @return JsonResource
     */
    public function show(LibOccupation $occupation): JsonResource
    {
        $query = LibOccupation::where('code', $occupation->code);
        $occupation = QueryBuilder::for($query)
            ->first();
        return new LibOccupationResource($occupation);
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
