<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibRapidQuestionaireResource;
use App\Models\V1\Libraries\LibRapidQuestionaire;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LibRapidQuestionaireController extends Controller
{
    /**
     * Display a listing of the PWD Type resource.
     *
     * @queryParam sort string Sort the sequence of Occupations. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibRapidQuestionaireResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibRapidQuestionaire
     */
    public function index()
    {
        $query = QueryBuilder::for(LibRapidQuestionaire::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibRapidQuestionaireResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified PWD Type resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibRapidQuestionaireResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibRapidQuestionaire
     */
    public function show(LibRapidQuestionaire $rapidQuestionaire)
    {
        $query = LibRapidQuestionaire::where('id', $rapidQuestionaire->id);
        $questionaire = QueryBuilder::for($query)
            ->first();

        return new LibRapidQuestionaireResource($questionaire);
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
