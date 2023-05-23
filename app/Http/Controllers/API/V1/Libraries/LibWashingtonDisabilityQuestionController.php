<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibWashingtonDisabilityQuestionResource;
use App\Models\V1\Libraries\LibWashingtonDisabilityQuestion;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for Washington Disability
 *
 * APIs for managing libraries
 *
 * @subgroup Washington Disability Question.
 *
 * @subgroupDescription List of Washington Disability Question.
 */
class LibWashingtonDisabilityQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibWashingtonDisabilityQuestionResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibWashingtonDisabilityQuestion
     */
    public function index()
    {
        $query = QueryBuilder::for(LibWashingtonDisabilityQuestion::class)
            ->defaultSort('sequence');

        return LibWashingtonDisabilityQuestionResource::collection($query->get());
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
