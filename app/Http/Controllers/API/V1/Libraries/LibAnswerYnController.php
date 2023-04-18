<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibAnswerYnResource;
use App\Models\V1\Libraries\LibAnswerYn;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for Generic Answers
 *
 * APIs for managing libraries
 *
 * @subgroup List of yn answer.
 *
 * @subgroupDescription List of yn answers.
 */
class LibAnswerYnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibAnswerYnResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibAnswerYn
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibAnswerYn::class);

        return LibAnswerYnResource::collection(($query->get()));
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
