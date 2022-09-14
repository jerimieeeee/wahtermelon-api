<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibSuffixNameResource;
use App\Models\V1\Libraries\LibSuffixName;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

class LibSuffixNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $query = QueryBuilder::for(LibSuffixName::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');
        return LibSuffixNameResource::collection($query->get());
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
     * @param LibSuffixName $suffixName
     * @return JsonResource
     */
    public function show(LibSuffixName $suffixName): JsonResource
    {
        $query = LibSuffixName::where('code', $suffixName->code);
        $suffixName = QueryBuilder::for($query)
            ->first();
        return new LibSuffixNameResource($suffixName);
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
