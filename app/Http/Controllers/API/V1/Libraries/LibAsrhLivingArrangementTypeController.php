<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibAsrhLivingArrangementTypeResource;
use App\Models\V1\Libraries\LibAsrhLivingArrangementType;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LibAsrhLivingArrangementTypeController extends Controller
{
    /**
     * Display a listing of the Refusal Reason resource.
     *
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibAsrhLivingArrangementTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibAsrhLivingArrangementType
     */
    public function index()
    {
        $query = QueryBuilder::for(LibAsrhLivingArrangementType::class);

        return LibAsrhLivingArrangementTypeResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Rapid Questionnaire resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibAsrhLivingArrangementTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibAsrhLivingArrangementType
     */
    public function show(LibAsrhLivingArrangementType $livingArrangementType)
    {
        $query = LibAsrhLivingArrangementType::where('id', $livingArrangementType->id);
        $livingArrangement = QueryBuilder::for($query)
            ->first();

        return new LibAsrhLivingArrangementTypeResource($livingArrangement);
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
