<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibRapidQuestionnaireResource;
use App\Models\V1\Libraries\LibRapidQuestionnaire;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LibRapidQuestionnaireController extends Controller
{
    /**
     * Display a listing of the PWD Type resource.
     *
     * @queryParam sort string Sort the sequence of Occupations. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibRapidQuestionnaireResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibRapidQuestionnaire
     */
    public function index()
    {
        $query = QueryBuilder::for(LibRapidQuestionnaire::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibRapidQuestionnaireResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibRapidQuestionnaireResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibRapidQuestionnaire
     */
    public function show(LibRapidQuestionnaire $rapidQuestionnaire)
    {
        $query = LibRapidQuestionnaire::where('id', $rapidQuestionnaire->id);
        $questionnaire = QueryBuilder::for($query)
            ->first();

        return new LibRapidQuestionnaireResource($questionnaire);
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
