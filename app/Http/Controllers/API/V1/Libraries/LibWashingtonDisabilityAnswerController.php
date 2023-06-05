<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibWashingtonDisabilityAnswerResource;
use App\Models\V1\Libraries\LibWashingtonDisabilityAnswer;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for Washington Disability
 *
 * APIs for managing libraries
 *
 * @subgroup Washington Disability Answer.
 *
 * @subgroupDescription List of Washington Disability Answer.
 */
class LibWashingtonDisabilityAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibWashingtonDisabilityAnswerResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibWashingtonDisabilityAnswer
     */
    public function index()
    {
        $query = QueryBuilder::for(LibWashingtonDisabilityAnswer::class)
            ->defaultSort('sequence');

        return LibWashingtonDisabilityAnswerResource::collection($query->get());
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
