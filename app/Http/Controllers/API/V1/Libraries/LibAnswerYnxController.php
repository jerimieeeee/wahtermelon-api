<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibAnswerYnxResource;
use App\Models\V1\Libraries\LibAnswerYnx;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for Generic Answers
 *
 * APIs for managing libraries
 *
 * @subgroup List of ynx answer.
 *
 * @subgroupDescription List of ynx answers.
 */
class LibAnswerYnxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibAnswerYnxResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibAnswerYnx
     */
    public function index()
    {
        $query = QueryBuilder::for(LibAnswerYnx::class);

        return LibAnswerYnxResource::collection(($query->get()));
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
