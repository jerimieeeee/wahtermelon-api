<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibOccupationCategoryResource;
use App\Models\V1\Libraries\LibOccupationCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

class LibOccupationCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $query = QueryBuilder::for(LibOccupationCategory::class)
            ->defaultSort('code')
            ->allowedSorts('code');
        return LibOccupationCategoryResource::collection($query->get());
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
     * @param LibOccupationCategory $occupationCategory
     * @return JsonResource
     */
    public function show(LibOccupationCategory $occupationCategory): JsonResource
    {
        $query = LibOccupationCategory::where('code', $occupationCategory->code);
        $occupationCategory = QueryBuilder::for($query)
            ->first();
        return new LibOccupationCategoryResource($occupationCategory);
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
