<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibTbTreatmentOutcomeResource;
use App\Models\V1\Libraries\LibTbTreatmentOutcome;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for TB
 *
 * APIs for managing libraries
 *
 * @subgroup Treatment Outcomes.
 *
 * @subgroupDescription List of Treatment Outcomes.
 */
class LibTbTreatmentOutcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibTbTreatmentOutcomeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibTbTreatmentOutcome
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibTbTreatmentOutcome::class)
            ->defaultSort('sequence');

        return LibTbTreatmentOutcomeResource::collection($query->get());
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
