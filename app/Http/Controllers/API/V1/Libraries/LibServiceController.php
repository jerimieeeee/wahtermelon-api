<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibServiceResource;
use App\Models\V1\Libraries\LibService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LibServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibServiceResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibService
     */
    public function index()
    {
        $query = QueryBuilder::for(LibService::class);

        return LibServiceResource::collection($query->get());
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
    public function show(LibService $service)
    {
        $query = LibService::where('id', $service->id);
        $service = QueryBuilder::for($query)
            ->first();

        return new LibServiceResource($service);
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
