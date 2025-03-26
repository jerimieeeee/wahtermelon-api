<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibAsrhRefusalReasonResource;
use App\Models\V1\Libraries\LibAsrhRefusalReason;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LibAsrhRefusalReasonController extends Controller
{
    /**
     * Display a listing of the Refusal Reason resource.
     *
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibAsrhRefusalReasonResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibAsrhRefusalReason
     */
    public function index()
    {
        $query = QueryBuilder::for(LibAsrhRefusalReason::class);

        return LibAsrhRefusalReasonResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibAsrhRefusalReasonResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibAsrhRefusalReason
     */
    public function show(LibAsrhRefusalReason $refusalReason)
    {
        $query = LibAsrhRefusalReason::where('id', $refusalReason->id);
        $reason = QueryBuilder::for($query)
            ->first();

        return new LibAsrhRefusalReasonResource($reason);
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
